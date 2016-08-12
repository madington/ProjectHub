<!doctype html>
<html lang="no">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title><?= $project->name ?> Timeline</title>

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

        <link rel="stylesheet" href="<?= $application->publicBaseUri ?>/css/style.css" media="all">
        <link rel="stylesheet" href="<?= $application->publicBaseUri ?>/css/firelabs.css" media="all">

    </head>
    <body>

        <h1><img src="//firecracker.no/images/empefire-logo.png" alt="Firelabs logotyp" title="Firelabs logotyp"></h1>
        <h1>
          <?= $project->name ?> Timeline
        </h1>

        <?php if ($projectCount > 1) : ?>
        <a href="<?= $application->publicBaseUri ?>/">
            <button type="button" class="btn btn-primary btn-lg">
                <i class="fa fa-chevron-left"></i>Show all projects
            </button>
        </a>
        <?php if (!empty($role) && $role == 'admin') { ?>
        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#saveNote">
            <i class="fa fa-plus"></i>New note
        </button>
        <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#deleteModal">
            <i class="fa fa-trash"></i>Delete project
        </button>
        <?php } ?>
        <a href="?action=logout" id="logout">
          <button type="button" class="btn btn-default btn-lg">
              <i class="fa fa-sign-out"></i>Log out
          </button>
        </a>

        <?php endif; ?>
        <ol class="timeline">
            <?php foreach ($project->timeline as $note) : ?>
            <li class="timeline-node">
                <button type="button" data-toggle="modal" data-target="#deleteNoteModal" data-id="<?=$note->id?>" class="btn btn-danger btn-sm delete-note"><i class="fa fa-trash"></i>Remove</button>

                <div class="timeline-stamp">
                    <?= $note->stamp ?>
                </div>
                <div class="timeline-content">
                    <?= $note->content ?>
                </div>
                <div class="timeline-links">
                    <?php foreach ($note->links as $label => $href) : ?>
                    <a href="<?= $href ?>" target="_blank">
                        <?= $label ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>

        <div class="modal fade" id="saveNote" tabindex="-1" role="dialog" aria-labelledby="saveNote">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="" method="post" class="form-horizontal save">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add a note</h4>
                        </div>
                        <div class="modal-body">

                                <input type="hidden" name="action" value="create-note">
                                <input type="hidden" name="project" value="<?= $project->id ?>">
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Date</label>
                                   <div class="col-sm-10">
                                       <input type="text" name="stamp" value="<?=date('r');?>" class="form-control">
                                   </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="content" class="form-control">
                                    </div>
                                  </div>

                                  <div id="sections">
                                      <div class="section">
                                        <div class="row">
                                        <div class="col-sm-2">
                                            <label class="control-label">Link</label>
                                        </div>
                                        <div class="col-sm-3">
                                          <label for="linkTitle" class="control-label sr-only">Title for link</label>
                                          <input type="text" name="link-title[]" id="linkTitle" class="form-control" placeholder="Title">
                                        </div>

                                        <div class="col-sm-3">
                                          <label for="linkUrl" class="control-label sr-only">URL for link</label>
                                          <input type="url" name="link-url[]" id="linkUrl" class="form-control" placeholder="URL">
                                        </div>

                                        <div class="col-sm-3">
                                          <a href="#" class="remove">
                                              <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i>Remove</button>
                                          </a>
                                        </div>
                                      </div>
                                      </div>
                                  </div>
                                  <div>
                                    <a href="#" class="addsection">
                                        <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>Add Link</button>
                                    </a>
                                  </div>
                        </div>
                        <div class="col-xs-12 modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-ban"></i>Reset</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal">
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
                            <p>Are you 100% sure you want to delete the project?<br>This action can not be undone 😮</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No, get me out of here</button>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>Yes, delete it</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteNoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post">
                        <input type="hidden" name="action" value="delete-note">
                        <input type="hidden" name="project" value="<?= $project->id ?>">
                        <input type="hidden" name="id" value="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Delete project</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the note?<br>This action can not be undone</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No, get me out of here</button>
                            <button type="submit" class="btn btn-danger">Yes, delete it</button>
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
