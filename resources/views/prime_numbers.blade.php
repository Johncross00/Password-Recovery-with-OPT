<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombres premiers</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Nombres premiers</h2>
        <form id="primeNumbersForm">
            @csrf
            <div class="form-group">
                <label for="number">Entrez un nombre</label>
                <input type="number" class="form-control" id="number" name="number" required min="2">
            </div>
            <button type="submit" class="btn btn-primary">Obtenir les nombres premiers</button>
        </form>

        <div id="primeNumbersResult" class="mt-4">
            <!-- Les résultats des nombres premiers seront affichés ici -->
        </div>
    </div>

    <script>
        document.getElementById('primeNumbersForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Récupérer le token d'authentification depuis localStorage
            const token = localStorage.getItem('token');
            if (!token) {
                alert('Vous devez être connecté pour effectuer cette opération.');
                return;
            }

            const number = document.getElementById('number').value;

            fetch('{{ url('/api/prime-numbers') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token // Ajout du token à l'en-tête
                },
                body: JSON.stringify({ number: number })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const primeNumbers = data.prime_numbers;
                    const resultDiv = document.getElementById('primeNumbersResult');

                    if (primeNumbers.length > 0) {
                        resultDiv.innerHTML = '<h5>Les nombres premiers avant ' + number + ' sont :</h5><ul>' +
                            primeNumbers.map(n => '<li>' + n + '</li>').join('') +
                            '</ul>';
                    } else {
                        resultDiv.innerHTML = '<h5>Aucun nombre premier trouvé avant ' + number + '.</h5>';
                    }
                } else {
                    alert('Erreur lors de la récupération des nombres premiers.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue. Veuillez réessayer.');
            });
        });
    </script>
</body>
</html>
