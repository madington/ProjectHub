<!doctype html>
<html lang="no">
<head>
    <meta charset="utf-8">
    <title><?= $project->name ?> Timeline</title>
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= $application->publicBaseUri ?>/css/style.css" media="all">
    <link rel="stylesheet" href="<?= $application->publicBaseUri ?>/css/empefire.css" media="all">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
</head>
<body>
    <h1><img src="//firecracker.no/images/empefire-logo.png" alt="Firelabs logotyp" title="Firelabs logotyp"></h1>
    <h1>
        <?= $project->name ?> Timeline
    </h1>
    <?php if ($projectCount > 1) : ?>
        <a href="/">
        <button type="button" class="btn btn-primary btn-lg">
          Show all projects
        </button>
        </a>
        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">
          New note
        </button>
        <a href="delete.php?project=<?= $_GET['project'] ?>" onclick="confirmation(event, 'Are you 100% sure you want to delete the project? This action can not be undone 😮')">
          <button type="button" class="btn btn-danger btn-lg">
            Delete project
        </button>

    <?php endif; ?>
    <ol class="timeline">
    <?php foreach ($project->timeline as $note) : ?>
        <li class="timeline-node">
            <div class="timeline-stamp"><?= $note->stamp ?></div>
            <div class="timeline-content"><?= $note->content ?></div>
            <div class="timeline-links">
            <?php foreach ($note->links as $label => $href) : ?>
                <a href="<?= $href ?>" target="_blank"><?= $label ?></a>
            <?php endforeach; ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ol>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="" method="post">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add a note</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">

                    <input type="hidden" name="project" value="<?= $project->id ?>" class="form-control">
                    <label for="new-project" class="control-label">Date</label>
                    <input type="text" name="stamp" value="<?=date('r');?>" class="form-control">
                    <label for="new-project" class="control-label">Title</label>
                    <input type="text" name="content" class="form-control">

                    <div id="sections">
                      <div class="section">
                        <fieldset>
                            <legend>Links</legend>
                            <p>
                                <label for="linkTitle" class="control-label">Title for link</label>
                                <input type="text" name="link-title[]" value="" id="linkTitle" class="form-control">
                            </p>

                            <p>
                                <label for="linkUrl" class="control-label">URL for link</label>
                                <input type="url" name="link-url[]" value="" id="linkUrl" class="form-control">
                            </p>

                            <p><a href="#" class='remove'><button type="button" class="btn btn-danger">Remove Link</button></a></p>

                        </fieldset>
                      </div>
                    </div>

                    <p><a href="#" class='addsection'><button type="button" class="btn btn-success">Add Link</button></a></p>


                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-success">Save</button>
              </div>
            </form>
            </div>
          </div>
        </div>

        <script src="<?= $application->publicBaseUri ?>/js/app.js"></script>

        <input type="submit" name="name" value="SEND">
    </form>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post">
              <input type="hidden" name="action" value="delete-project">
              <input type="hidden" name="project" value="<?= $project->id ?>">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Delete project</h4>
          </div>
          <div class="modal-body">
              <p>Are you 100% sure you want to delete the project? This action can not be undone 😮</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No, get me out of here</button>
            <button type="submit" class="btn btn-success">Yes, delete it</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
    <script src="/public/js/app.js"></script>
</body>
</html>
