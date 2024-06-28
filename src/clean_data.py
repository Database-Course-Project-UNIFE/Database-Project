import pandas as pd
import numpy as np
import re


artist_df = pd.read_csv('csv-files/artist_data.csv')
artwork_df = pd.read_csv('csv-files/artwork_data.csv')


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


# Clean artist_data.csv
# Create a copy of artist dataframe to work on it
artist_df_copy = artist_df.copy()

artist_df_copy.drop_duplicates(inplace=True)     # Drop duplicates
artist_df_copy.dropna(inplace=True)              # Drop rows with missing values

# Verify the data types of each column and convert them to the correct data type
# Desired data types
artist_desired_dtypes = {
    'id'          : int,
    'name'        : str,
    'gender'      : str,
    'yearOfBirth' : int, 
    'yearOfDeath' : int,
    'placeOfBirth': str,
    'placeOfDeath': str,
    'url'         : str,
}

# Convert artist_df_copy data types
artist_df_copy = convert_dtypes(artist_df_copy, artist_desired_dtypes)

artist_df_copy['gender'].fillna('-', inplace=True)
artist_df_copy['gender'].replace({'Male': 'M', 'Female': 'F'}, inplace=True)
artist_df_copy['yearOfBirth'].fillna('0')
artist_df_copy['yearOfDeath'].fillna('0')
artist_df_copy['placeOfBirth'].fillna('Unknown')
artist_df_copy['placeOfDeath'].fillna('Unknown')

# Save cleaned artist data
artist_df_copy.to_csv('csv-files/cleaned_artist_data.csv', index=False)


# Clean artwork_data.csv
# Create a copy of artwork dataframe to work on it
artwork_df_copy = artwork_df.copy()

artwork_df_copy.drop_duplicates(inplace=True)    # Drop duplicates
artwork_df_copy.dropna(inplace=True)             # Drop rows with missing values

# Verify the data types of each column and convert them to the correct data type
# Desired data types
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

# Convert artwork_df_copy data types
artwork_df_copy = convert_dtypes(artwork_df_copy, artwork_desired_types)

# Data extraction
acquisitionYear = artwork_df_copy['creditLine'].str.extract(r'(\d{4})')         # acquisitionYear extraction
acquisitionYear_Series = acquisitionYear.iloc[:, 0]
artwork_df_copy['acquisitionYear'].fillna(acquisitionYear_Series, inplace=True)

size_width = artwork_df_copy['dimension'].str.extract(r'(\d+)\s*[xX]\s*\d+')    # width extraction
size_width_series = size_width.iloc[:, 0]
artwork_df_copy['width'].fillna(size_width_series, inplace=True)

size_height = artwork_df_copy['dimension'].str.extract(r'\d+\s*[xX]\s*(\d+)')   # height extraction
size_height_series = size_height.iloc[:, 0]
artwork_df_copy['height'].fillna(size_height_series, inplace=True)

# Handle null values
artwork_df_copy['medium'].fillna('Unknown', inplace=True)
artwork_df_copy['creditLine'].fillna('Unknown', inplace=True)
artwork_df_copy['year'].fillna(0, inplace=True)
artwork_df_copy['acquisitionYear'].fillna(0, inplace=True)
artwork_df_copy['dimensions'].fillna('Unknown', inplace=True)
artwork_df_copy['depth'].fillna(0, inplace=True)
artwork_df_copy['units'].fillna('mm', inplace=True)
artwork_df_copy['inscription'].fillna('inscribed', inplace=True)

# Reorganization of columns
artwork_df_copy = artwork_df_copy[['id', 'accession_number', 'artist', 'artistRole', 'artistId', 'title', 'dateText', 'medium', 'creditLine', 'year', 'acquisitionYear', 
                                 'types', 'dimensions', 'width', 'height', 'depth', 'units', 'inscription', 'url']]

# drop dimensions column
artwork_df_copy.drop(columns=['dimensions'], inplace=True)

# Save cleaned artwork data
artwork_df_copy.to_csv('csv-files/cleaned_artwork_data.csv', index=False)