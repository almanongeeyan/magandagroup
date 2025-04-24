import mysql.connector
from mysql.connector import Error
from datetime import datetime, timedelta


def connect_db():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="library_db"
    )

def add_new_book():
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

        print(f"Book '{title}' added successfully.")

    except Error as error:
        print("Failed to insert book data: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def borrow_book():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Borrow a Book ---")
        cursor.execute("SELECT book_id, title, author FROM books WHERE status = 'Free'")
        available_books = cursor.fetchall()
        if available_books:
            print("--- Available Books ---")
            for book in available_books:
                print(f"Book ID: {book[0]}, Title: {book[1]}, Author: {book[2]}")
            print("-" * 30)
        else:
            print("No books are currently available.")

        search_type = input("Search by (1) Book ID or (2) Title to borrow: ")

        if search_type == '1':
            book_id = input("Enter Book ID to borrow: ")
            cursor.execute("SELECT title, status FROM books WHERE book_id = %s", (book_id,))
            book = cursor.fetchone()
            if book:
                title, status = book
                if status == 'Free':
                    borrower_name = input("Enter borrower's name: ")
                    borrow_date = datetime.now().strftime('%Y-%m-%d')
                    due_date = (datetime.now() + timedelta(days=14)).strftime('%Y-%m-%d')
                    update_book_sql = "UPDATE books SET status = 'Borrowed' WHERE book_id = %s"
                    cursor.execute(update_book_sql, (book_id,))

                    record_borrower_sql = "INSERT INTO borrowers (book_id, borrower_name, borrow_date, due_date) VALUES (%s, %s, %s, %s)"
                    cursor.execute(record_borrower_sql, (book_id, borrower_name, borrow_date, due_date))

                    conn.commit()
                    print(f"Book '{title}' marked as borrowed by '{borrower_name}'. Due date: {due_date}")
                else:
                    print("Book is not available for borrowing.")
            else:
                print("Book not found.")
        elif search_type == '2':
            title = input("Enter title of the book to borrow: ")
            cursor.execute("SELECT book_id, status, title FROM books WHERE title LIKE %s AND status = 'Free'", ('%' + title + '%',))
            books = cursor.fetchall()
            if books:
                if len(books) > 1:
                    print("Multiple available books found with that title. Please search by Book ID.")
                    for book_info in books:
                        print(f"Book ID: {book_info[0]}, Title: {book_info[2]}")
                else:
                    book_id, status, book_title = books[0]
                    borrower_name = input("Enter borrower's name: ")
                    borrow_date = datetime.now().strftime('%Y-%m-%d')
                    due_date = (datetime.now() + timedelta(days=14)).strftime('%Y-%m-%d')

                    update_book_sql = "UPDATE books SET status = 'Borrowed' WHERE book_id = %s"
                    cursor.execute(update_book_sql, (book_id,))

                    record_borrower_sql = "INSERT INTO borrowers (book_id, borrower_name, borrow_date, due_date) VALUES (%s, %s, %s, %s)"
                    cursor.execute(record_borrower_sql, (book_id, borrower_name, borrow_date, due_date))

                    conn.commit()
                    print(f"Book '{book_title}' marked as borrowed by '{borrower_name}'. Due date: {due_date}")
            else:
                print("No available book found with that title.")
        else:
            print("Invalid input.")

    except Error as error:
        print("Failed to update book status or record borrower: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def return_book():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Return a Book ---")
        cursor.execute("SELECT b.book_id, b.title, br.borrower_name FROM books b JOIN borrowers br ON b.book_id = br.book_id")
        borrowed_books = cursor.fetchall()
        if borrowed_books:
            print("--- Currently Borrowed Books ---")
            for book in borrowed_books:
                print(f"Book ID: {book[0]}, Title: {book[1]}, Borrower: {book[2]}")
            print("-" * 30)
        else:
            print("No books are currently borrowed.")

        search_type = input("Search by (1) Book ID or (2) Title to return: ")

        if search_type == '1':
            book_id = input("Enter Book ID to return: ")
            cursor.execute("SELECT title, status FROM books WHERE book_id = %s", (book_id,))
            book = cursor.fetchone()
            if book:
                title, status = book
                if status == 'Borrowed':
                    update_book_sql = "UPDATE books SET status = 'Free' WHERE book_id = %s"
                    cursor.execute(update_book_sql, (book_id,))

                    delete_borrower_sql = "DELETE FROM borrowers WHERE book_id = %s"
                    cursor.execute(delete_borrower_sql, (book_id,))

                    conn.commit()
                    print(f"Book '{title}' returned successfully.")
                else:
                    print("Book is already marked as available.")
            else:
                print("Book not found.")
        elif search_type == '2':
            title = input("Enter title of the book to return: ")
            cursor.execute("SELECT b.book_id, b.title, b.status FROM books b JOIN borrowers br ON b.book_id = br.book_id WHERE b.title LIKE %s", ('%' + title + '%',))
            books = cursor.fetchall()
            if books:
                if len(books) > 1:
                    print("Multiple borrowed books found with that title. Please search by Book ID.")
                    for book_info in books:
                        print(f"Book ID: {book_info[0]}, Title: {book_info[1]}")
                else:
                    book_id, book_title, status = books[0]
                    if status == 'Borrowed':
                        update_book_sql = "UPDATE books SET status = 'Free' WHERE book_id = %s"
                        cursor.execute(update_book_sql, (book_id,))

                        delete_borrower_sql = "DELETE FROM borrowers WHERE book_id = %s"
                        cursor.execute(delete_borrower_sql, (book_id,))

                        conn.commit()
                        print(f"Book '{book_title}' returned successfully.")
                    else:
                        print("Book is already marked as available.")
            else:
                print("No borrowed book found with that title.")
        else:
            print("Invalid input.")

    except Error as error:
        print("Failed to update book status or borrower records: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def archive_book():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Archive Book (Lost/Missing) ---")
        cursor.execute("SELECT book_id, title, author, status FROM books")
        all_books = cursor.fetchall()
        if all_books:
            print("--- All Books ---")
            for book in all_books:
                print(f"Book ID: {book[0]}, Title: {book[1]}, Author: {book[2]}, Status: {book[3]}")
            print("-" * 40)
        else:
            print("No books in the library.")

        search_type = input("Search by (1) Book ID or (2) Title to archive: ")

        if search_type == '1':
            book_id = input("Enter Book ID to archive: ")
            cursor.execute("SELECT title FROM books WHERE book_id = %s", (book_id,))
            book_to_archive = cursor.fetchone()
            if book_to_archive:
                print("Reason for archiving:")
                print("1. Lost")
                print("2. Missing")
                reason_choice = input("Enter your choice (1 or 2): ")
                if reason_choice == '1':
                    archive_reason = 'Lost'
                elif reason_choice == '2':
                    archive_reason = 'Missing'
                else:
                    print("Invalid choice.")
                    return
                lost_in = input("Enter the place where the book was lost (if applicable, else leave blank): ")
                archive_date = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

                cursor.execute("SELECT title, genre, author, published_date, status FROM books WHERE book_id = %s", (book_id,))
                book_details = cursor.fetchone()

                if book_details:
                    title, genre, author, published_date, status = book_details
                    archive_sql = "INSERT INTO archive (book_id, title, genre, author, published_date, status, archive_reason, lost_in, archive_date) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
                    cursor.execute(archive_sql, (book_id, title, genre, author, published_date, status, archive_reason, lost_in, archive_date))

                    delete_book_sql = "DELETE FROM books WHERE book_id = %s"
                    cursor.execute(delete_book_sql, (book_id,))

                    delete_borrower_sql = "DELETE FROM borrowers WHERE book_id = %s"
                    cursor.execute(delete_borrower_sql, (book_id,))

                    conn.commit()
                    print(f"Book '{title}' archived as '{archive_reason}' successfully.")
                else:
                    print("Error retrieving book details.")
            else:
                print("Book not found.")
        elif search_type == '2':
            title = input("Enter title of the book to archive: ")
            cursor.execute("SELECT book_id, title FROM books WHERE title LIKE %s", ('%' + title + '%',))
            books_to_archive = cursor.fetchall()
            if books_to_archive:
                if len(books_to_archive) > 1:
                    print("Multiple books found with that title. Please search by Book ID to archive.")
                    for book_info in books_to_archive:
                        print(f"Book ID: {book_info[0]}, Title: {book_info[1]}")
                else:
                    book_id, book_title = books_to_archive[0]
                    print("Reason for archiving:")
                    print("1. Lost")
                    print("2. Missing")
                    reason_choice = input("Enter your choice (1 or 2): ")
                    if reason_choice == '1':
                        archive_reason = 'Lost'
                    elif reason_choice == '2':
                        archive_reason = 'Missing'
                    else:
                        print("Invalid choice.")
                        return
                    lost_in = input("Enter the place where the book was lost (if applicable, else leave blank): ")
                    archive_date = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

                    cursor.execute("SELECT genre, author, published_date, status FROM books WHERE book_id = %s", (book_id,))
                    book_details = cursor.fetchone()

                    if book_details:
                        genre, author, published_date, status = book_details
                        archive_sql = "INSERT INTO archive (book_id, title, genre, author, published_date, status, archive_reason, lost_in, archive_date) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
                        cursor.execute(archive_sql, (book_id, book_title, genre, author, published_date, status, archive_reason, lost_in, archive_date))

                        delete_book_sql = "DELETE FROM books WHERE book_id = %s"
                        cursor.execute(delete_book_sql, (book_id,))

                        delete_borrower_sql = "DELETE FROM borrowers WHERE book_id = %s"
                        cursor.execute(delete_borrower_sql, (book_id,))

                        conn.commit()
                        print(f"Book '{book_title}' archived as '{archive_reason}' successfully.")
                    else:
                        print("Error retrieving book details.")
            else:
                print("Book not found.")
        else:
            print("Invalid input.")

    except Error as error:
        print("Failed to archive book: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def view_available_books():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Available Books ---")
        cursor.execute("SELECT * FROM books WHERE status = 'Free'")
        available_books = cursor.fetchall()

        if available_books:
            for book in available_books:
                print(f"Book ID            : {book[0]}")
                print(f"Title              : {book[1]}")
                print(f"Genre              : {book[2]}")
                print(f"Author             : {book[3]}")
                print(f"Published Date     : {book[4]}")
                print(f"Status             : {book[5]}")
                print("-" * 20)
        else:
            print("No books are currently free.")

        search_again = input("Do you want to search for a specific available book by (1) Book ID or (2) Title? (0 for no): ")
        if search_again == '1':
            book_id = input("Enter Book ID to view details: ")
            cursor.execute("SELECT * FROM books WHERE book_id = %s AND status = 'Free'", (book_id,))
            book = cursor.fetchone()
            if book:
                print("\n--- Available Book Details ---")
                print(f"Book ID            : {book[0]}")
                print(f"Title              : {book[1]}")
                print(f"Genre              : {book[2]}")
                print(f"Author             : {book[3]}")
                print(f"Published Date     : {book[4]}")
                print(f"Status             : {book[5]}")
            else:
                print("Available book not found with that ID.")
        elif search_again == '2':
            title = input("Enter title of the available book to view: ")
            cursor.execute("SELECT * FROM books WHERE title LIKE %s AND status = 'Free'", ('%' + title + '%',))
            books = cursor.fetchall()
            if books:
                print("\n--- Available Book Details ---")
                for book in books:
                    print(f"Book ID            : {book[0]}")
                    print(f"Title              : {book[1]}")
                    print(f"Genre              : {book[2]}")
                    print(f"Author             : {book[3]}")
                    print(f"Published Date     : {book[4]}")
                    print(f"Status             : {book[5]}")
                    print("-" * 20)
            else:print("No available books found with that title.")
        elif search_again == '0':
            pass
        else:
            print("Invalid choice.")

    except Error as error:
        print("Failed to fetch available books: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def view_borrowed_books():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Currently Borrowed Books ---")
        cursor.execute("SELECT b.book_id, b.title, br.borrower_name, br.borrow_date, br.due_date FROM books b JOIN borrowers br ON b.book_id = br.book_id")
        borrowed_books = cursor.fetchall()

        if borrowed_books:
            for book in borrowed_books:
                print(f"Book ID    : {book[0]}")
                print(f"Title      : {book[1]}")
                print(f"Borrower   : {book[2]}")
                print(f"Borrow Date: {book[3]}")
                print(f"Due Date   : {book[4]}")
                print("-" * 30)
        else:
            print("No books are currently borrowed.")

        search_again = input("Do you want to search for a specific borrowed book by (1) Book ID or (2) Title? (0 for no): ")
        if search_again == '1':
            book_id = input("Enter Book ID to view details: ")
            cursor.execute("SELECT b.book_id, b.title, br.borrower_name, br.borrow_date, br.due_date FROM books b JOIN borrowers br ON b.book_id = br.book_id WHERE b.book_id = %s", (book_id,))
            book = cursor.fetchone()
            if book:
                print("\n--- Borrowed Book Details ---")
                print(f"Book ID    : {book[0]}")
                print(f"Title      : {book[1]}")
                print(f"Borrower   : {book[2]}")
                print(f"Borrow Date: {book[3]}")
                print(f"Due Date   : {book[4]}")
            else:
                print("Borrowed book not found with that ID.")
        elif search_again == '2':
            title = input("Enter title of the borrowed book to view: ")
            cursor.execute("SELECT b.book_id, b.title, br.borrower_name, br.borrow_date, br.due_date FROM books b JOIN borrowers br ON b.book_id = br.book_id WHERE b.title LIKE %s", ('%' + title + '%',))
            books = cursor.fetchall()
            if books:
                print("\n--- Borrowed Book Details ---")
                for book in books:
                    print(f"Book ID    : {book[0]}")
                    print(f"Title      : {book[1]}")
                    print(f"Borrower   : {book[2]}")
                    print(f"Borrow Date: {book[3]}")
                    print(f"Due Date   : {book[4]}")
                    print("-" * 30)
            else:
                print("No borrowed books found with that title.")
        elif search_again == '0':
            pass
        else:
            print("Invalid choice.")

    except Error as error:
        print("Failed to fetch borrowed books: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def view_archived_books():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Archived Books ---")
        cursor.execute("SELECT * FROM archive")
        archived_books = cursor.fetchall()

        if archived_books:
            for book in archived_books:
                print(f"Archive ID         : {book[0]}")
                print(f"Book ID            : {book[1]}")
                print(f"Title              : {book[2]}")
                print(f"Genre              : {book[3]}")
                print(f"Author             : {book[4]}")
                print(f"Published Date     : {book[5]}")
                print(f"Status             : {book[6]}")
                print(f"Archived Reason    : {book[7]}")
                print(f"Lost In            : {book[8]}")
                print(f"Archive Date       : {book[9]}")
                print("-" * 30)
        else:
            print("No books have been archived.")

        # Option to search by ID or Title after viewing all
        search_again = input("Do you want to search for a specific archived book by (1) Book ID or (2) Title? (0 for no): ")
        if search_again == '1':
            book_id = input("Enter Book ID to view details: ")
            cursor.execute("SELECT * FROM archive WHERE book_id = %s", (book_id,))
            book = cursor.fetchone()
            if book:
                print("\n--- Archived Book Details ---")
                print(f"Archive ID         : {book[0]}")
                print(f"Book ID            : {book[1]}")
                print(f"Title              : {book[2]}")
                print(f"Genre              : {book[3]}")
                print(f"Author             : {book[4]}")
                print(f"Published Date     : {book[5]}")
                print(f"Status             : {book[6]}")
                print(f"Archived Reason    : {book[7]}")
                print(f"Lost In            : {book[8]}")
                print(f"Archive Date       : {book[9]}")
            else:
                print("Archived book not found with that ID.")
        elif search_again == '2':
            title = input("Enter title of the archived book to view: ")
            cursor.execute("SELECT * FROM archive WHERE title LIKE %s", ('%' + title + '%',))
            books = cursor.fetchall()
            if books:
                print("\n--- Archived Book Details ---")
                for book in books:
                    print(f"Archive ID         : {book[0]}")
                    print(f"Book ID            : {book[1]}")
                    print(f"Title              : {book[2]}")
                    print(f"Genre              : {book[3]}")
                    print(f"Author             : {book[4]}")
                    print(f"Published Date     : {book[5]}")
                    print(f"Status             : {book[6]}")
                    print(f"Archived Reason    : {book[7]}")
                    print(f"Lost In            : {book[8]}")
                    print(f"Archive Date       : {book[9]}")
                    print("-" * 30)
            else:
                print("No archived books found with that title.")
        elif search_again == '0':
            pass
        else:
            print("Invalid choice.")

    except Error as error:
        print("Failed to fetch archived books: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()


def view_overdue_books():
    try:
        conn = connect_db()
        cursor = conn.cursor()

        print("\n--- Overdue Books ---")
        today = datetime.now().strftime('%Y-%m-%d')
        cursor.execute("SELECT b.book_id, b.title, br.borrower_name, br.due_date FROM books b JOIN borrowers br ON b.book_id = br.book_id WHERE br.due_date < %s", (today,))
        overdue_books = cursor.fetchall()

        if overdue_books:
            for book in overdue_books:
                print(f"Book ID    : {book[0]}")
                print(f"Title      : {book[1]}")
                print(f"Borrower   : {book[2]}")
                print(f"Due Date   : {book[3]}")
                print("-" * 30)
        else:
            print("No books are currently overdue.")

        # Option to search by ID or Title after viewing all
        search_again = input("Do you want to search for a specific overdue book by (1) Book ID or (2) Title? (0 for no): ")
        if search_again == '1':
            book_id = input("Enter Book ID to view details: ")
            cursor.execute("SELECT b.book_id, b.title, br.borrower_name, br.due_date FROM books b JOIN borrowers br ON b.book_id = br.book_id WHERE br.due_date < %s AND b.book_id = %s", (today, book_id,))
            book = cursor.fetchone()
            if book:
                print("\n--- Overdue Book Details ---")
                print(f"Book ID    : {book[0]}")
                print(f"Title      : {book[1]}")
                print(f"Borrower   : {book[2]}")
                print(f"Due Date   : {book[3]}")
            else:
                print("Overdue book not found with that ID.")
        elif search_again == '2':
            title = input("Enter title of the overdue book to view: ")
            cursor.execute("SELECT b.book_id, b.title, br.borrower_name, br.due_date FROM books b JOIN borrowers br ON b.book_id = br.book_id WHERE br.due_date < %s AND b.title LIKE %s", (today, '%' + title + '%',))
            books = cursor.fetchall()
            if books:
                print("\n--- Overdue Book Details ---")
                for book in books:
                    print(f"Book ID    : {book[0]}")
                    print(f"Title      : {book[1]}")
                    print(f"Borrower   : {book[2]}")
                    print(f"Due Date   : {book[3]}")
                    print("-" * 30)
            else:
                print("No overdue books found with that title.")
        elif search_again == '0':
            pass
        else:
            print("Invalid choice.")

    except Error as error:
        print("Failed to fetch overdue books: {}".format(error))
    finally:
        if conn and conn.is_connected():
            cursor.close()
            conn.close()

def main():
    while True:
        print("\nHi, welcome sa aming munting sistema ng pamamahala ng aklatan ni Aliyah Estrella Policarpio a.k.a Michelle")
        print("1. Add New Book")
        print("2. Borrow Book")
        print("3. Return Book")
        print("4. Archive Book (Lost/Missing)")
        print("5. View Available Books")
        print("6. View Borrowed Books")
        print("7. View Archive Books")
        print("8. View Overdue Books")
        print("0. Exit")
        choice = input("Enter your choice: ")
        if choice == '1':
            add_new_book()
        elif choice == '2':
            borrow_book()
        elif choice == '3':
            return_book()
        elif choice == '4':
            archive_book()
        elif choice == '5':
            view_available_books()
        elif choice == '6':
            view_borrowed_books()
        elif choice == '7':
            view_archived_books()
        elif choice == '8':
            view_overdue_books()
        elif choice == '0':
            print("Siri Play Bye Bye by Mariah Carey")
            break
        else:
            print("0 to 8 lang choices mo, bat pipindot ka pa ng ibang number")

if __name__ == "__main__":
    main()

'''
yung cursor function is bridge sha ng python and mysql
para maka insert ng data and get ng data from library_db
'''