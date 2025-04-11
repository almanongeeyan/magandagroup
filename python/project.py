
'''
check muna ng python version
python --version
then.... install sa cmd para ma run yung program
python -m pip install mysql-connector-python
'''

import mysql.connector
from mysql.connector import Error

def connect_db():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="library_db"
    )

def add_book():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Add a New Book ---")
        title = input("Enter book title: ")
        genre = input("Enter book genre: ")
        author = input("Enter book author: ")
        published_date = input("Enter published date (YYYY-MM-DD): ")

        sql = "INSERT INTO books (title, genre, author, published_date, status) VALUES (%s, %s, %s, %s, %s)"
        values = (title, genre, author, published_date, 'Free')

        cursor.execute(sql, values)
        conn.commit()

        print("Book added successfully.")

    except Error as error:
        print("Failed to insert data: {}".format(error))
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

def view_books():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- View Book ---")
        search_type = input("Search by (1) Book ID or (2) Title: ")

        if search_type == '1':
            book_id = input("Enter Book ID: ")
            cursor.execute("SELECT * FROM books WHERE book_id = %s", (book_id,))
        elif search_type == '2':
            title = input("Enter Title: ")
            cursor.execute("SELECT * FROM books WHERE title = %s", (title,))
        else:
            print("Invalid input.")
            return

        result = cursor.fetchone()
        if result:
            print("\nBook Details:")
            print(f"Book ID       : {result[0]}")
            print(f"Title         : {result[1]}")
            print(f"Genre         : {result[2]}")
            print(f"Author        : {result[3]}")
            print(f"Published Date: {result[4]}")
            print(f"Status        : {result[5]}")
        else:
            print("Book not found.")

    except Error as error:
        print("Failed to fetch data: {}".format(error))
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

def mark_borrowed():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Mark Book as Borrowed ---")
        search_type = input("Search by (1) Book ID or (2) Title: ")

        if search_type == '1':
            book_id = input("Enter Book ID: ")
            cursor.execute("UPDATE books SET status = 'Borrowed' WHERE book_id = %s", (book_id,))
        elif search_type == '2':
            title = input("Enter Title: ")
            cursor.execute("UPDATE books SET status = 'Borrowed' WHERE title = %s", (title,))
        else:
            print("Invalid input.")
            return

        conn.commit()
        if cursor.rowcount > 0:
            print("Book status updated to 'Borrowed'.")
        else:
            print("Book not found or already marked as 'Borrowed'.")

    except Error as error:
        print("Failed to update book status: {}".format(error))
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

def mark_free():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Mark Book as Free ---")
        search_type = input("Search by (1) Book ID or (2) Title: ")

        if search_type == '1':
            book_id = input("Enter Book ID: ")
            cursor.execute("UPDATE books SET status = 'Free' WHERE book_id = %s", (book_id,))
        elif search_type == '2':
            title = input("Enter Title: ")
            cursor.execute("UPDATE books SET status = 'Free' WHERE title = %s", (title,))
        else:
            print("Invalid input.")
            return

        conn.commit()
        if cursor.rowcount > 0:
            print("Book status updated to 'Free'.")
        else:
            print("Book not found or already marked as 'Free'.")

    except Error as error:
        print("Failed to update book status: {}".format(error))
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

def main():
    while True:
        print("\nLibrary Management System Ni Aliyah")
        print("Hi, welcome sa aming munting sistema ng pamamahala ng aklatan ni Aliyah Estrella Policarpio a.k.a Michelle")
        print("1. Add New Book")
        print("2. View Book")
        print("3. Mark Book as Borrowed")
        print("4. Mark Book as Free")
        print("0. Exit")
        choice = input("Enter your choice: ")
        if choice == '1':
            add_book()
        elif choice == '2':
            view_books()
        elif choice == '3':
            mark_borrowed()
        elif choice == '4':
            mark_free()
        elif choice == '0':
            print("Siri Play Bye Bye by Mariah Carey")
            break
        else:
            print("0 to 4 lang choices mo, bat pipindot ka pa ng ibang number")

main()
'''
yung cursor function is bridge sha ng python and mysql
para maka insert ng data and get ng data from library_db
'''