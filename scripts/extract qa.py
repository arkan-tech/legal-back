import mysql.connector
import json

# Database connection configuration
DB_CONFIG = {
    "host": "64.226.100.230",
    "user": "root",
    "password": "/er-x1k/9A(QFQ//",
    "database": "ymtazsa_db_prod",
}


def fetch_data_and_create_array():
    try:
        # Connect to the database
        connection = mysql.connector.connect(**DB_CONFIG)
        cursor = connection.cursor(dictionary=True)

        # Query the database
        query = "SELECT id, name, about FROM law_guide"
        cursor.execute(query)
        rows = cursor.fetchall()

        # Process the data
        data_array = []
        prefix_text = "ما هو "  # Replace with your desired prefix

        for row in rows:
            data_object = {
                "prompt": f"{prefix_text}{row['name']}؟",
                "completion": row["about"],
            }
            data_array.append(data_object)

        cursor.reset()
        query = f"SELECT lw.name, lw.law, lw.changes, lwl.name as lawGuideName FROM law_guide_laws lw left join law_guide lwl on lw.law_guide_id = lwl.id where lw.law_guide_id in ({','.join([str(row['id']) for row in rows])})"
        cursor.execute(query)
        rows = cursor.fetchall()
        data_array_2 = []
        for row in rows:
            if "الباب" in row["name"]:
                data_object = {
                    "prompt": f"{prefix_text}{row['name']} في {row['lawGuideName']}؟",
                    "completion": row["law"] + (row["changes"] or ""),
                }
            else:
                data_object = {
                    "prompt": f"ما هي {row['name']} في {row['lawGuideName']}؟",
                    "completion": row["law"] + (row["changes"] or ""),
                }
            data_array_2.append(data_object)
        # Merge the two arrays with first 5 values in first array and all values in second
        data_array = data_array[:5] + data_array_2
        # Print or return the array as JSON
        with open("output.json", "w", encoding="utf-8") as json_file:
            json.dump(
                data_array,
                json_file,
                ensure_ascii=False,
                indent=4,
            )
        return data_array

    except mysql.connector.Error as e:
        print(f"Error: {e}")
    finally:
        # Close the database connection
        if cursor:
            cursor.close()
        if connection:
            connection.close()


if __name__ == "__main__":
    fetch_data_and_create_array()
