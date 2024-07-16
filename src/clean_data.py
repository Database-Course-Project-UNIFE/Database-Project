import pandas as pd
import numpy as np
import re
import os


# Function for convert data types 
def convert_dtypes(df, desired_dtypes):
    for column, dtype in desired_dtypes.items():
        if column in df.columns:
            if df[column].dtype != dtype:
                # Converti la colonna al tipo desiderato
                if dtype == int:
                    df[column] = pd.to_numeric(df[column], errors='coerce').astype(int)
                elif dtype == float:
                    df[column] = pd.to_numeric(df[column], errors='coerce').astype(float)
                elif dtype == str:
                    df[column] = df[column].astype(str)
    return df


def clean_artist_data(df):
    df['gender'] = df['gender'].fillna('-', inplace = True)
    df['gender'] = df.replace({'Male': 'M', 'Female': 'F'}, inplace=True)
    df['placeOfBirth'] = df['placeOfBirth'].fillna('Unknown')
    df['placeOfDeath'] = df['placeOfDeath'].fillna('Unknown')
    
    # Split 'placeOfBiorth' in 'birthCity' and 'birthState'
    birth_split = df['placeOfBirth'].str.split(', ', expand=True)
    df['birthCity'] = birth_split[0]
    df['birthState'] = birth_split[1].fillna('Unknown')

    # Split 'placeOfDeath' in 'deathCity' and 'deathState' 
    death_split = df['placeOfDeath'].str.split(', ', expand=True)
    df['deathCity'] = death_split[0]
    df['deathState'] = death_split[1].fillna('Unknown')

    # Converting 'yearOfbirth' and 'yearOfDeath' columns to integers type
    df['yearOfBirth'] = df['yearOfBirth'].replace(np.nan, 0).astype(int)
    df['yearOfDeath'] = df['yearOfDeath'].replace(np.nan, 0).astype(int)

    # Replace missing values
    df['birthCity'] = df['birthCity'].fillna('Unknown')
    df['birthState'] = df['birthState'].fillna('Unknown')
    df['deathCity'] = df['deathCity'].fillna('Unknown')
    df['deathState'] = df['deathState'].fillna('Unknown')
    
    df.drop(columns=['placeOfBirth', 'placeOfDeath', 'dates'], inplace=True)
    columns_to_keep = ['id', 'name', 'gender', 'yearOfBirth', 'birthCity', 'birthState',
                       'yearOfDeath', 'deathCity', 'deathState', 'url']
    
    return df[columns_to_keep]


def clean_artwork_data(df):
    # Drop the 'thumbnailCopyright' column
    df.drop(columns=['thumbnailCopyright'], inplace=True)
    
    # Extract acquisitionYear and width from creditLine and dimension columns
    df['acquisitionYear'] = df['creditLine'].str.extract(r'(\d{4})').iloc[:, 0]
    df['width'] = df['dimensions'].str.extract(r'(\d+)\s*[xX]\s*\d+').astype(float).iloc[:, 0]
    df['height'] = df['dimensions'].str.extract(r'\d+\s*[xX]\s*(\d+)').astype(float).iloc[:, 0]
    
    # Fill missing values
    df['units'] = df['units'].fillna('mm')
    df['creditLine'] = df['creditLine'].fillna('Unknown')
    df['depth'] = df['depth'].fillna(0)
    df['year'] = df['year'].fillna(0)
    df['inscription'] = df['inscription'].fillna('date inscribed')
    df['dimensions'] = df['dimensions'].fillna('Unknown')
    df['medium'] = df['medium'].fillna('Unknown')
    df['acquisitionYear'] = df['acquisitionYear'].fillna(0)
    df['thumbnailUrl'] = df['thumbnailUrl'].fillna('Unknown')

    # Convert column type
    df['year'] = pd.to_numeric(df['year'].replace('no date', np.nan), errors='coerce').fillna(0).astype(int)
    df['acquisitionYear'] = pd.to_numeric(df['acquisitionYear'], errors='coerce').fillna(0).astype(int)
    df['width'] = pd.to_numeric(df['width'], errors='coerce').fillna(0).astype(int)
    df['height'] = pd.to_numeric(df['height'], errors='coerce').fillna(0).astype(int)
    df['depth'] = df['depth'].astype(int)
    df['thumbnailUrl'] = df['thumbnailUrl'].str.replace("/www.", "/media.")

    # Extract type without dimensions from 'dimensions' column
    df['types'] = df['dimensions'].apply(extract_type_without_dimensions)
    
    columns_to_keep = ['id', 'accession_number', 'artist', 'artistRole', 'artistId', 'title', 'dateText', 
                       'medium', 'creditLine', 'year', 'acquisitionYear', 'types', 'width', 'height', 
                       'depth', 'units', 'inscription', 'thumbnailUrl', 'url']
    return df[columns_to_keep]


def extract_type_without_dimensions(dimension_str):
    match = re.search(r'\d', dimension_str) if any(char.isdigit() for char in dimension_str) else None
    text_part = dimension_str[:match.start()].strip() if match else dimension_str.strip()
    return text_part.replace(':', '').strip() or None


def main():
    source_path = "/mnt/c/Users/nicol/OneDrive/Documenti/GitHub/Database-Project/csv-files"

    artist_data_csv = os.path.join(source_path, "artist_data.csv")
    artworks_data_csv = os.path.join(source_path, "artwork_data.csv")
    cleaned_artist_data_csv = os.path.join(source_path, "cleaned_artist_data.csv")
    cleaned_artworks_data_csv = os.path.join(source_path, "cleaned_artwork_data.csv")

    artist_df = pd.read_csv(artist_data_csv)
    artwork_df = pd.read_csv(artworks_data_csv)

    # clean and save artist data
    cleaned_artist_df = clean_artist_data(artist_df.copy())
    artist_desired_dtypes ={
        'id'          : int,
        'name'        : str,
        'gender'      : str,
        'yearOfBirth' : int,
        'yearOfDeath' : int,
        'birthCity'   : str,
        'birthState'  : str,
        'deathCity'   : str,
        'deathState'  : str, 
        'url'         : str
    }

    cleaned_artist_df = convert_dtypes(cleaned_artist_df, artist_desired_dtypes)
    cleaned_artist_df.to_csv(cleaned_artist_data_csv, index=False)

    # clean and save artwork data
    cleaned_artwork_df = clean_artwork_data(artwork_df.copy())
    artwork_desired_types = {
        'id'                : int,
        'accession_number'  : str,
        'artist'            : str,
        'artistRole'        : str,
        'artistId'          : int,
        'title'             : str,
        'dateText'          : str,
        'medium'            : str,
        'creditLine'        : str,
        'year'              : int,
        'acquisitionYear'   : int,
        'types'             : str,
        'width'             : int,
        'height'            : int,
        'depth'             : float,
        'units'             : str,
        'inscription'       : str,
        'thumbnailCopyright': str,
        'thumbnailUrl'      : str,
        'url'               : str
    }

    cleaned_artwork_df = convert_dtypes(cleaned_artwork_df, artwork_desired_types)
    cleaned_artwork_df.to_csv(cleaned_artworks_data_csv, index=False)


if __name__ == "__main__":
    main()