import requests
import pandas as pd

# 1. Configuración de parámetros para el sector de Mochuelo (Bogotá)
# Puedes cambiar los años aquí ('start_date' y 'end_date') si lo requieres.
coordenadas = {
    "latitude": 4.542,
    "longitude": -74.148,
    "start_date": "2025-10-18",
    "end_date": "2026-10-18",
    "hourly": "relative_humidity_2m", # Parámetro oficial para Humedad Relativa
    "timezone": "America/Bogota"
}
print("Conectando con la API de Open-Meteo para obtener datos de humedad...")

print("Conectando con la API de Open-Meteo para obtener datos de humedad...")

# Modificamos la URL al endpoint de pronóstico histórico compatible
url = "https://historical-forecast-api.open-meteo.com/v1/forecast"

# 2. Realizamos la petición fuera del try para aislar la respuesta HTTP
respuesta = requests.get(url, params=coordenadas)

# Validamos explícitamente el código de respuesta del servidor antes de procesar
if respuesta.status_code != 200:
    print(f"\n❌ Error del servidor de la API (Código {respuesta.status_code}):")
    print(respuesta.text)  # Esto imprimirá la razón exacta del fallo dictada por Open-Meteo
    exit()

try:
    # 3. Si la respuesta es exitosa (200 OK), procesamos el JSON de forma segura
    datos = respuesta.json()
    datos_horarios = datos["hourly"]
    
    # Construcción del DataFrame inicial (Granularidad por hora)
    df = pd.DataFrame({
        "fecha_hora": pd.to_datetime(datos_horarios["time"]),
        "humedad_relativa_hora_%": datos_horarios["relative_humidity_2m"]
    })
    
    # Establecer la columna temporal como índice para realizar los cálculos analíticos
    df.set_index("fecha_hora", inplace=True)
    
    print("Procesando agregaciones de humedad (Diaria, Semanal y Mensual)...")
    
    # 4. Cálculo de promedios agregados sin perder el formato fila por hora
    df["promedio_diario_%"] = df["humedad_relativa_hora_%"].groupby(df.index.date).transform("mean").round(2)
    df["promedio_semanal_%"] = df["humedad_relativa_hora_%"].groupby(df.index.to_period("W")).transform("mean").round(2)
    df["promedio_mensual_%"] = df["humedad_relativa_hora_%"].groupby(df.index.to_period("M")).transform("mean").round(2)
    
    # Restablecer el índice para la exportación limpia
    df.reset_index(inplace=True)
    
    # 5. Exportación del set de datos a formato .csv
    nombre_archivo = "humedad_mochuelo_bogota.csv"
    df.to_csv(nombre_archivo, index=False, encoding="utf-8-sig")
    
    print(f"\n¡Éxito! El archivo '{nombre_archivo}' ha sido generado correctamente.")
    print("\nVista previa de las primeras filas del dataset:")
    print(df.head(10).to_string(index=False))

except KeyError as e:
    print(f"Error: El formato de respuesta no contiene la columna esperada: {e}")
except Exception as e:
    print(f"Ocurrió un error inesperado al procesar los datos: {e}")

