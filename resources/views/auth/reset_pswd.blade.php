<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .spinner-border {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Réinitialisation de mot de passe</h2>
        <form id="resetPasswordForm">
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="otp">Code OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
        </form>
        <p class="mt-3">Retour à la <a href="{{ url('/login') }}">connexion</a></p>

        <div id="loadingSpinner" class="text-center mt-4">
            <div class="spinner-border" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            document.getElementById('loadingSpinner').querySelector('.spinner-border').style.display = 'block';

            const email = document.getElementById('email').value;
            const otp = document.getElementById('otp').value;
            const password = document.getElementById('password').value;

            fetch('{{ url('/api/reset-pswd') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    otp: otp,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingSpinner').querySelector('.spinner-border').style.display = 'none';

                if (data.success) {
                    alert(data.message);

                    window.location.href = '{{ url('/login') }}';
                } else {
                    alert(data.error || 'Erreur lors de la réinitialisation du mot de passe. Veuillez réessayer.');
                }
            })
            .catch(error => {
                document.getElementById('loadingSpinner').querySelector('.spinner-border').style.display = 'none';

                console.error('Erreur:', error);
                alert('Une erreur est survenue. Veuillez réessayer.');
            });
        });
    </script>
</body>
</html>
