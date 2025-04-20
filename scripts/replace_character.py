import mysql.connector


def replace_character_in_names():
    # Database connection configuration
    config = {
        "user": "root",
        "password": "/er-x1k/9A(QFQ//",
        "host": "64.226.100.230",
        "database": "ymtazsa_db_prod",
    }

    # Connect to the database
    conn = mysql.connector.connect(**config)
    cursor = conn.cursor()

    # Select all names from the accounts table
    cursor.execute("SELECT id, name FROM accounts")
    accounts = cursor.fetchall()

    # Replace the specified character and update the names
    for account in accounts:
        account_id, name = account
        new_name = name.replace("ـ", "")
        cursor.execute(
            "UPDATE accounts SET name = %s WHERE id = %s", (new_name, account_id)
        )

    # Commit the changes and close the connection
    conn.commit()
    cursor.close()
    conn.close()


if __name__ == "__main__":
    replace_character_in_names()
