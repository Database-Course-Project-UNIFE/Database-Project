import pandas as pd


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


artist_df = pd.read_csv('csv-files/artist_data.csv')
artwork_df = pd.read_csv('csv-files/artwork_data.csv')


# Clean artist_data.csv
artist_df.drop_duplicates(inplace=True)     # Drop duplicates
artist_df.dropna(inplace=True)              # Drop rows with missing values

# Verify the data types of each column and convert them to the correct data type
# Desired data types
artist_desired_dtypes = {
    'id': int,
    'name': str,
    'gender': str,
    'yearOfBirth': int, 
    'yearOfDeath': int,
    'placeOfBirth': str,
    'placeOfDeath': str,
    'url': str,
}

# Convert artist_df data types
artist_df = convert_dtypes(artist_df, artist_desired_dtypes)

# Handle null values
artist_df['id'] = artist_df['id'].fillna(0)
artist_df['name'] = artist_df['name'].fillna('')
artist_df['gender'] = artist_df['gender'].fillna('')
artist_df['yearOfBirth'] = artist_df['yearOfBirth'].fillna('')
artist_df['url'] = artist_df['url'].fillna('')


# Clean artwork_data.csv
artwork_df.drop_duplicates(inplace=True)    # Drop duplicates
artwork_df.dropna(inplace=True)             # Drop rows with missing values

# Verify the data types of each column and convert them to the correct data type
# Desired data types
artwork_desired_types = {
    'id': int,
    'accession_number': str,
    'artist': str,
    'artistRole': str,
    'artistId': int,
    'title': str,
    'dateText': str,
    'medium': str,
    'creditLine': str,
    'year': int,
    'acquisitionYear': int,
    'types': str,
    'width': int,
    'height': int,
    'depth': float,
    'units': str,
    'inscription': str,
    'thumbnailCopyright': str,
    'thumbnailUrl': str,
    'url': str
}

# Convert artwork_df data types
artwork_df = convert_dtypes(artwork_df, artwork_desired_types)

# Handle null values
artwork_df['id'] = artwork_df['id'].fillna(0)
artwork_df['accession_number'] = artwork_df['accession_number'].fillna('')
artwork_df['artistId'] = artwork_df['artistId'].fillna(0)


# Save clen data
artist_df.to_csv('csv-files/clean_artist_data.csv', index=False)
artwork_df.to_csv('csv-files/clean_artwork_data.csv', index=False)