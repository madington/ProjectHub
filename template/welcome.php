<!doctype html>
<html lang="no">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title>Welcome to Firelabs</title>

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

        <link rel="stylesheet" href="<?= $application->publicBaseUri ?>/css/style.css" media="all">
        <link rel="stylesheet" href="<?= $application->publicBaseUri ?>/css/firelabs.css" media="all">

    </head>
    <body>
        <?php include('header.php'); ?>
        <?php if (!empty($role) && $role == 'admin') { ?>
        <button class="btn btn-success btn-lg glyphicon glyphicon-plus" data-toggle="modal" data-target="#saveProject">
            <i class="fa fa-plus"></i>New project
        </button>
        <?php } ?>
        <a href="?action=logout" id="logout">
          <button class="btn btn-default btn-lg glyphicon glyphicon-log-out">
              <i class="fa fa-sign-out"></i>Log out
          </button>
        </a>
		<h1>Velkommen til Firelabs.no</h1>

		<p>Din konto venter på godkjenning av administrator.<br>
		Du vil om kort tid kunne logge inn med din nye bruker.</p>

		<p>Kontakt <a href="mailto:accounts@empefire.no">accounts@empefire.no</a> dersom du har spørsmål.</p>
        <div class="modal fade" id="saveProject" tabindex="-1" role="dialog" aria-labelledby="saveProject">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" class="save">
                        <input type="hidden" name="action" value="create-project">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add a project</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="new-project" class="control-label">Name of the new project</label>
                                <input type="text" name="title" class="form-control" id="new-project">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default glyphicon glyphicon-remove" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                            <button type="reset" class="btn btn-default glyphicon glyphicon-ban-circle"><i class="fa fa-ban"></i>Reset</button>
                            <button type="submit" class="btn btn-success glyphicon glyphicon-ok"><i class="fa fa-check"></i>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
        <script src="<?= $application->publicBaseUri ?>/js/app.js"></script>
    </body>

</html>
