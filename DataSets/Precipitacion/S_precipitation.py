import requests
import pandas as pd

# 1. Configuración de parámetros para el sector de Mochuelo (Bogotá)
coordenadas = {
    "latitude": 4.542,
    "longitude": -74.148,
    "start_date": "2025-10-18",
    "end_date": "2026-10-18",
    "hourly": "precipitation", # Parámetro oficial para precipitación líquida/lluvia
    "timezone": "America/Bogota"
}

print("Conectando con la API de Open-Meteo para obtener datos de precipitación...")
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
        "precipitacion_hora_mm": datos_horarios["precipitation"]
    })
    
    # Establecer el índice temporal para los cálculos agregados
    df.set_index("fecha_hora", inplace=True)
    
    print("Procesando acumulaciones climáticas (Suma Diaria, Semanal y Mensual)...")
    
    # 4. Cálculo de SUMAS acumuladas (Método correcto para análisis de lluvias)
    df["total_lluvia_diario_mm"] = df["precipitacion_hora_mm"].groupby(df.index.date).transform("sum").round(2)
    df["total_lluvia_semanal_mm"] = df["precipitacion_hora_mm"].groupby(df.index.to_period("W")).transform("sum").round(2)
    df["total_lluvia_mensual_mm"] = df["precipitacion_hora_mm"].groupby(df.index.to_period("M")).transform("sum").round(2)
    
    # Restablecer el índice para la exportación limpia
    df.reset_index(inplace=True)
    
    # 5. Exportación del set de datos a formato .csv
    nombre_archivo = "precipitacion_mochuelo_bogota.csv"
    df.to_csv(nombre_archivo, index=False, encoding="utf-8-sig")
    
    print(f"\n¡Éxito! El archivo '{nombre_archivo}' ha sido generado correctamente.")
    print("\nVista previa de las primeras filas del dataset:")
    print(df.head(10).to_string(index=False))

except KeyError as e:
    print(f"Error: Columna faltante en la respuesta del servidor: {e}")
except Exception as e:
    print(f"Ocurrió un error inesperado al procesar los datos: {e}")
