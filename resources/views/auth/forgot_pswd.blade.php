<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération de mot de passe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .spinner-border {
            display: none; /* Cache le spinner par défaut */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Récupération de mot de passe</h2>
        <form id="forgotPasswordForm">
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer OTP</button>
        </form>
        <p class="mt-3">Retour à la <a href="{{ url('/login') }}">connexion</a></p>

        <!-- Spinner de chargement -->
        <div id="loadingSpinner" class="text-center mt-4">
            <div class="spinner-border" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Afficher le spinner de chargement
            document.getElementById('loadingSpinner').querySelector('.spinner-border').style.display = 'block';

            const email = document.getElementById('email').value;

            fetch('{{ url('/api/forgot-pwsd') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                })
            })
            .then(response => response.json())
            .then(data => {
                // Cacher le spinner de chargement
                document.getElementById('loadingSpinner').querySelector('.spinner-border').style.display = 'none';

                if (data.success) {
                    alert(data.message);

                    window.location.href = '{{ route('reset_password') }}';
                } else {
                    alert('Erreur lors de la récupération du mot de passe. Veuillez réessayer.');
                }
            })
            .catch(error => {
                // Cacher le spinner de chargement
                document.getElementById('loadingSpinner').querySelector('.spinner-border').style.display = 'none';

                console.error('Erreur:', error);
                alert('Une erreur est survenue. Veuillez réessayer.');
            });
        });
    </script>
</body>
</html>
