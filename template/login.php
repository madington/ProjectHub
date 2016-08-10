<!doctype html>
<html lang="no">
<head>
    <meta charset="utf-8">
    <title>Firelabs</title>
    <meta name="viewport" content="width=device-width">

  	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="<?= $application->publicBaseUri ?>/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="<?= $application->publicBaseUri ?>/css/empefire.css" media="all">
  	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.auth0.com/js/lock/10.0/lock.min.js"></script>
    <script type="text/javascript">
      var lock = new Auth0Lock('cYDYeEw8mKS9AnVtNaWSY05ioGFkZjb4', 'firelabs.eu.auth0.com', {
        auth: {
          redirectUrl: 'http://localhost/?auth',
          responseType: 'code',
          params: {
            scope: 'openid email' // Learn about scopes: https://auth0.com/docs/scopes
          }
        }
      });
    </script>
</head>
<body>

	<h1><img src="//firecracker.no/images/empefire-logo.png" alt="Firelabs logotyp" title="Firelabs logotyp"></h1>
    <script type="text/javascript">
        lock.show();
    </script>
</body>
</html>
