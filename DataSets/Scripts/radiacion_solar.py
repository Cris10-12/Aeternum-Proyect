import requests
import pandas as pd
import time

# 1. Configuración de parámetros fijos para el sector de Mochuelo (Bogotá)
latitud = 4.542
longitud = -74.148
url_api = "https://historical-forecast-api.open-meteo.com/v1/forecast"

# Definición de los 4 periodos solicitados (desde 2022 hasta 2026)
periodos = [
    {"start": "2022-10-18", "end": "2023-10-18", "nombre": "radiacion_mochuelo_2022_2023.csv"},
    {"start": "2023-10-18", "end": "2024-10-18", "nombre": "radiacion_mochuelo_2023_2024.csv"},
    {"start": "2024-10-18", "end": "2025-10-18", "nombre": "radiacion_mochuelo_2024_2025.csv"},
    {"start": "2025-10-18", "end": "2026-10-18", "nombre": "radiacion_mochuelo_2025_2026.csv"}
]

print("Iniciando descarga automatizada de radiación solar para los 4 periodos...\n")

for p in periodos:
    print(f"⏳ Procesando periodo: {p['start']} al {p['end']}...")
    
    coordenadas = {
        "latitude": latitud,
        "longitude": longitud,
        "start_date": p["start"],
        "end_date": p["end"],
        "hourly": "shortwave_radiation",  # Radiación solar de onda corta global
        "timezone": "America/Bogota"
    }
    
    try:
        # 2. Petición al servidor de Open-Meteo
        respuesta = requests.get(url_api, params=coordenadas)
        
        if respuesta.status_code != 200:
            print(f"❌ Error del servidor en este periodo (Código {respuesta.status_code}): {respuesta.text}")
            continue  # Salta al siguiente periodo si este falla
            
        datos = respuesta.json()
        datos_horarios = datos["hourly"]
        
        # 3. Construcción del DataFrame (Granularidad por hora)
        df = pd.DataFrame({
            "fecha_hora": pd.to_datetime(datos_horarios["time"]),
            "radiacion_solar_hora_Wm2": datos_horarios["shortwave_radiation"]
        })
        
        # Establecer índice temporal para los cálculos agregados
        df.set_index("fecha_hora", inplace=True)
        
        # 4. Cálculo de acumulación energética (Suma) diario, semanal y mensual
        df["total_radiacion_diario_Wm2"] = df["radiacion_solar_hora_Wm2"].groupby(df.index.date).transform("sum").round(2)
        df["total_radiacion_semanal_Wm2"] = df["radiacion_solar_hora_Wm2"].groupby(df.index.to_period("W")).transform("sum").round(2)
        df["total_radiacion_mensual_Wm2"] = df["radiacion_solar_hora_Wm2"].groupby(df.index.to_period("M")).transform("sum").round(2)
        
        # Restablecer índice para guardar limpio
        df.reset_index(inplace=True)
        
        # 5. Exportar el archivo correspondiente al periodo
        df.to_csv(p["nombre"], index=False, encoding="utf-8-sig")
        print(f"✅ ¡Guardado con éxito! Archivo: '{p['nombre']}'\n")
        
        # Pausa de cortesía de 1 segundo entre peticiones para respetar la API gratuita
        time.sleep(1)
        
    except Exception as e:
        print(f"💥 Error inesperado procesando este periodo: {e}\n")

print("🎉 Proceso finalizado por completo. Revisa tu carpeta para ver los 4 archivos generados.")
