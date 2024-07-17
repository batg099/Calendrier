import os
import pandas as pd

def convert_excel_to_csv(excel_file_path, csv_file_path):
    if os.path.exists(excel_file_path):
        print(f"Conversion de {excel_file_path} vers {csv_file_path}")
        # Lire le fichier Excel
        df = pd.read_excel(excel_file_path)
        # Sauvegarder en CSV
        df.to_csv(csv_file_path, index=False,sep=',')
    else:
        print(f"Le fichier {excel_file_path} n'existe pas.")

if __name__ == "__main__":
    # Liste des fichiers Excel et leurs chemins de sortie en CSV
    files_to_convert = [
        ("/var/www/html/uploads/Produits.xlsx", "/var/www/html/uploads/Produits_2.csv"),
        ("/var/www/html/uploads/liste.xlsx", "/var/www/html/uploads/liste.csv")
    ]

    # Boucler Ã  travers les fichiers et les convertir
    for excel_file_path, csv_file_path in files_to_convert:
        convert_excel_to_csv(excel_file_path, csv_file_path)
