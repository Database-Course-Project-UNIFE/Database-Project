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

# Create copies of dataframes to work on them
artist_df_copy = artist_df.copy()
artwork_df_copy = artwork_df.copy() 

# Clean artist_data.csv
artist_df_copy.drop_duplicates(inplace=True)     # Drop duplicates
artist_df_copy.dropna(inplace=True)              # Drop rows with missing values

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

# Convert artist_df_copy data types
artist_df_copy = convert_dtypes(artist_df_copy, artist_desired_dtypes)

# Handle null values
artist_df_copy['id'] = artist_df_copy['id'].fillna(0)
artist_df_copy['name'] = artist_df_copy['name'].fillna('')
artist_df_copy['gender'] = artist_df_copy['gender'].fillna('')
artist_df_copy['yearOfBirth'] = artist_df_copy['yearOfBirth'].fillna('')
artist_df_copy['url'] = artist_df_copy['url'].fillna('')


# Clean artwork_data.csv
artwork_df_copy.drop_duplicates(inplace=True)    # Drop duplicates
artwork_df_copy.dropna(inplace=True)             # Drop rows with missing values

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

# Convert artwork_df_copy data types
artwork_df_copy = convert_dtypes(artwork_df_copy, artwork_desired_types)

# Handle null values
artwork_df_copy['id'] = artwork_df_copy['id'].fillna(0)
artwork_df_copy['accession_number'] = artwork_df_copy['accession_number'].fillna('')
artwork_df_copy['artistId'] = artwork_df_copy['artistId'].fillna('')


# Save cleaned data
artist_df_copy.to_csv('csv-files/cleaned_artist_data.csv', index=False)
artwork_df_copy.to_csv('csv-files/cleaned_artwork_data.csv', index=False)