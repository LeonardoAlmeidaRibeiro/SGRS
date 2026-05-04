import json
import sys


FACTORS = {
    "plastico": {"co2": 1.7, "agua": 18, "energia": 2.4, "valor": 0.9},
    "papel": {"co2": 1.2, "agua": 45, "energia": 1.8, "valor": 0.55},
    "papelao": {"co2": 1.2, "agua": 45, "energia": 1.8, "valor": 0.55},
    "metal": {"co2": 2.8, "agua": 30, "energia": 5.4, "valor": 1.8},
    "sucata": {"co2": 2.8, "agua": 30, "energia": 5.4, "valor": 1.8},
    "vidro": {"co2": 0.9, "agua": 12, "energia": 1.4, "valor": 0.35},
    "organico": {"co2": 0.6, "agua": 8, "energia": 0.7, "valor": 0.25},
    "madeira": {"co2": 1.1, "agua": 10, "energia": 1.2, "valor": 0.4},
}


def normalize(value):
    return (
        value.lower()
        .replace("á", "a")
        .replace("à", "a")
        .replace("ã", "a")
        .replace("â", "a")
        .replace("é", "e")
        .replace("ê", "e")
        .replace("í", "i")
        .replace("ó", "o")
        .replace("õ", "o")
        .replace("ô", "o")
        .replace("ú", "u")
        .replace("ç", "c")
    )


def factors_for(material):
    normalized = normalize(material)
    for key, factors in FACTORS.items():
        if key in normalized:
            return factors
    return {"co2": 1.6, "agua": 22, "energia": 2.1, "valor": 0.75}


payload = json.loads(sys.argv[1] if len(sys.argv) > 1 else "{}")
quantity = float(payload.get("quantidade_kg") or 0)
factors = factors_for(payload.get("tipo_material") or "")

print(json.dumps({
    "co2_economizado": round(quantity * factors["co2"], 3),
    "agua_economizada": round(quantity * factors["agua"], 3),
    "energia_economizada": round(quantity * factors["energia"], 3),
    "valor_economizado": round(quantity * factors["valor"], 2),
}))
