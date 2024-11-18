<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        #container {
            width: 90%;
            max-width: 1200px;
        }

        #divContainer {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            gap: 10px;
        }

        #bookList {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding-top: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: calc(20% - 20px);
            min-width: 200px;
            box-sizing: border-box;
            text-align: center;
        }

        .card:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
            transition: 0.3s ease;
        }

        .card h2 {
            font-size: 18px;
            color: #0056b3;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }
        form {
            display: flex;
            flex-direction: row; 
            gap: 15px; 
            flex-wrap: wrap; 
            justify-content: center; 
            align-items: center; 
        }

        input[type="text"],
        input[type="date"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            width: 200px; 
        }

        input[type="text"]:focus,
        input[type="date"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            padding: 12px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0; 
        }

        button:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        h1,
        h2,
        h3 {
            font-weight: 700;
        }

        p,
        input,
        button {
            font-weight: 400;
        }
    </style>
</head>

<body>
    <div id="container">
        <div id="divContainer">
            <form id="bookForm" method="post" onsubmit="onHandleAddBooks(event)">
                <input type="text" placeholder="id" name="id" required>
                <input type="text" placeholder="title" name="title" required>
                <input type="text" placeholder="author" name="author" required>
                <input type="date" placeholder="release_date" name="release_date" required>
                <button type="submit">Submit</button>
            </form>
            <form id="deleteForm" method="POST" onsubmit="onHandleDeleteBooksByid(event);">
                <input id="delete" name="delete" type="text" placeholder="type the id you want to delete" required>
                <button type="submit">Delete</button>
        </div>
        <main id="bookList">

        </main>

    </div>
    </div>
</body>
<script>
    async function onHandleAddBooks(event) {
        event.preventDefault();
        const form = document.getElementById('bookForm');
        const formData = new FormData(form);

        const response = await fetch('add_book.php', {
            method: 'POST',
            body: formData,

        });

        const data = await response.json();
        const books = data.data;

        if (data.status === 'success') {
            onLoadFetch();
        } else {
            console.error('Erro ao adicionar o livro:', data.message);
        }
    }
    async function onLoadFetch() {
        try {
            const response = await fetch('add_book.php', {
                method: 'GET',
            });

            const jsonResponse = await response.json();

            if (jsonResponse.status === 'success') {
                const books = jsonResponse.data;

                const listBooks = document.getElementById('bookList');
                listBooks.innerHTML = '';

                books.forEach((book) => {
                    const bookCard = document.createElement('div');
                    bookCard.classList.add('card');

                    const idElement = document.createElement('h2');
                    idElement.textContent = `ID: ${book.id}`;
                    bookCard.appendChild(idElement);

                    const titleElement = document.createElement('p');
                    titleElement.textContent = `Título: ${book.title}`;
                    bookCard.appendChild(titleElement);

                    const authorElement = document.createElement('p');
                    authorElement.textContent = `Autor: ${book.author}`;
                    bookCard.appendChild(authorElement);

                    const releaseDateElement = document.createElement('p');
                    releaseDateElement.textContent = `Lançamento: ${book.release_date}`;
                    bookCard.appendChild(releaseDateElement);

                    listBooks.appendChild(bookCard);
                });
            } else {
                console.error('Erro ao listar os livros:', jsonResponse.message);
            }
        } catch (error) {
            console.error('Erro na requisição GET:', error);
        }
    }

    async function onHandleDeleteBooksByid(event) {
        event.preventDefault();
        const form = document.getElementById('deleteForm');
        const formData = new FormData(form);
        form.reset();

        const response = await fetch('delete_book.php', {
            method: 'POST',
            body: formData,

        });
        const data = await response.json();
        const books = data.data;

        if (data.status === 'success') {
            onLoadFetch();
        } else {
            console.error('Erro ao deletar o livro:', data.message);
        }
    }

    onLoadFetch();
</script>

</html>