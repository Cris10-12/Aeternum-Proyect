import requests
import pandas as pd

# 1. Configuración de parámetros para el sector de Mochuelo (Bogotá)
coordenadas = {
    "latitude": 4.542,
    "longitude": -74.148,
    "start_date": "2025-10-18",
    "end_date": "2026-10-18",
    # Solicitamos únicamente las variables del viento a 10 metros de altura
    "hourly": "wind_speed_10m,wind_direction_10m",
    "timezone": "America/Bogota"
}

print("Conectando con la API de Open-Meteo para obtener datos del viento...")
url = "https://historical-forecast-api.open-meteo.com/v1/forecast"

# 2. Petición al servidor
respuesta = requests.get(url, params=coordenadas)

if respuesta.status_code != 200:
    print(f"\n❌ Error del servidor de la API (Código {respuesta.status_code}):")
    print(respuesta.text)
    exit()

try:
    # 3. Procesamiento seguro de los datos JSON
    datos = respuesta.json()
    datos_horarios = datos["hourly"]
    
    # Construcción del DataFrame inicial por hora
    df = pd.DataFrame({
        "fecha_hora": pd.to_datetime(datos_horarios["time"]),
        "viento_velocidad_kmh": datos_horarios["wind_speed_10m"],
        "viento_direccion_grados": datos_horarios["wind_direction_10m"]
    })
    
    # Establecer el índice temporal para los cálculos agregados
    df.set_index("fecha_hora", inplace=True)
    
    print("Calculando agregaciones del viento (Diaria, Semanal y Mensual)...")
    
    # --- Agregaciones de Velocidad del Viento ---
    df["viento_vel_promedio_diario"] = df["viento_velocidad_kmh"].groupby(df.index.date).transform("mean").round(2)
    df["viento_vel_promedio_semanal"] = df["viento_velocidad_kmh"].groupby(df.index.to_period("W")).transform("mean").round(2)
    df["viento_vel_promedio_mensual"] = df["viento_velocidad_kmh"].groupby(df.index.to_period("M")).transform("mean").round(2)
    
    # --- Agregaciones de Dirección del Viento ---
    df["viento_dir_promedio_diario"] = df["viento_direccion_grados"].groupby(df.index.date).transform("mean").round(2)
    df["viento_dir_promedio_semanal"] = df["viento_direccion_grados"].groupby(df.index.to_period("W")).transform("mean").round(2)
    df["viento_dir_promedio_mensual"] = df["viento_direccion_grados"].groupby(df.index.to_period("M")).transform("mean").round(2)
    
    # Restablecer el índice para la exportación limpia
    df.reset_index(inplace=True)
    
    # 4. Guardar el archivo en formato .csv
    nombre_archivo = "viento_mochuelo_bogota.csv"
    df.to_csv(nombre_archivo, index=False, encoding="utf-8-sig")
    
    print(f"\n¡Éxito! El archivo '{nombre_archivo}' ha sido generado correctamente.")
    print("\nVista previa de las primeras filas del dataset:")
    print(df.head(10).to_string(index=False))

except KeyError as e:
    print(f"Error: Columna faltante en la respuesta del servidor: {e}")
except Exception as e:
    print(f"Ocurrió un error inesperado al procesar los datos: {e}")
