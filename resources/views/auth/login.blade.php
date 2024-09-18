<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Connexion</h2>
        <form id="loginForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        <p class="mt-3">Mot de passe oublié ? <a href="{{ url('/forgot-password') }}">Récupérer mot de passe</a></p>
        <p class="mt-3">Pas encore inscrit ? <a href="{{ url('/register') }}">Créer un compte</a></p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('{{ url('/api/login') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); 

                    if (data.access_token) {
                        localStorage.setItem('token', data.access_token);

                        alert('Connexion réussie !');
                        window.location.href = '{{ url('/prime-numbers') }}';
                    } else {
                        alert('Erreur : Données Incorrectes.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur inattendue : ' + error.message);
                });
        });
    </script>
</body>
</html>
