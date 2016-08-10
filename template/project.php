<!doctype html>
<html lang="no">
<head>
    <meta charset="utf-8">
    <title><?= $project->name ?> Timeline</title>
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="<?= $application->publicBaseUri ?>/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="<?= $application->publicBaseUri ?>/css/empefire.css" media="all">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <script>
    function confirmation(event, text) {
    	var answer = confirm(text);
    	if (!answer) {
    		event.preventDefault();
    	}
    }
    </script>
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
        <a href="delete.php?project=<?= $_GET['project'] ?>" onclick="confirmation(event, 'Are you 100% sure you want to delete the project? This action can not be undone 😮')">
          <button type="button" class="btn btn-danger btn-lg">
            Delete project
          </button>
        </a>
    <?php endif; ?>
    <ol class="timeline">
    <?php foreach ($project->timeline as $note) : ?>
        <li class="timeline-node">
            <div class="timeline-stamp"><?= $note->stamp ?></div>
            <div class="timeline-content"><?= $note->content ?></div>
            <div class="timeline-links">
            <?php foreach ($note->links as $label => $href) : ?>
                <a href="<?= $href ?>"><?= $label ?></a>
            <?php endforeach; ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ol>
    <form class="" method="post">
        <input type="hidden" name="project" value="<?= $project->id ?>">
        <label>Date</label>
        <input type="text" name="stamp" value="<?=date('r');?>">
        <label>Title</label>
        <input type="text" name="content" value="">

        <div id="sections">
          <div class="section">
            <fieldset>
                <legend>Links</legend>
                <p>
                    <label for="linkTitle">Title:</label>
                    <input name="link-title[]" id="linkTitle" value="" type="text" />
                </p>

                <p>
                    <label for="linkUrl">Url:</label>
                    <input name="link-url[]" id="linkUrl" value="" type="url" />
                </p>

                <p><a href="#" class='remove'>Remove Link</a></p>

            </fieldset>
          </div>
        </div>

        <p><a href="#" class='addsection'>Add Link</a></p>

        <input type="submit" name="name" value="SEND">
    </form>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
    <script src="/public/js/app.js"></script>
</body>
</html>
