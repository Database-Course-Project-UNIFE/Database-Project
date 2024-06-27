import pandas as pd

artist_df = pd.read_csv('csv-files/artist_data.csv')
artwork_df = pd.read_csv('csv-files/artwork_data.csv')

# Clean artist_data.csv
artist_df.drop_duplicates(inplace=True)     # Drop duplicates
artist_df.dropna(inplace=True)              # Drop rows with missing values

# Verify the data types of each column and convert them to the correct data type
# Desired data types
desired_dtypes = {
    'id': int,
    'name': str,
    'gender': str,
    'yearOfBirth': int, 
    'yearOfDeath': int,
    'placeOfBirth': str,
    'placeOfDeath': str,
    'url': str,
}

# Function for convert data types and handle null values
def convert_dtypes(df, desired_dtypes):
    for column, dtype in desired_dtypes.items():
        if column in df.columns:
            if df[column].dtype != dtype:
                # Converti la colonna al tipo desiderato
                if dtype == int:
                    df[column] = pd.to_numeric(df[column], errors='coerce').fillna(0).astype(int)
                elif dtype == str:
                    df[column] = df[column].fillna('').astype(str)

# Convert artist_df data types
artist_df = convert_dtypes(artist_df, desired_dtypes)



# Save clen data
artist_df.to_csv('csv-files/clean_artist_data.csv', index=False)
artwork_df.to_csv('csv-files/clean_artwork_data.csv', index=False)