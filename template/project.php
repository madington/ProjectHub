<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $project->name ?> Timeline</title>
    <meta name="viewport" content="width=device-width"/>
    <link rel="stylesheet" type="text/css" href="<?= $application->publicBaseUri ?>/css/style.css" media="all"/>
</head>
<body>
    <?php if ($projectCount > 1) : ?>
        <div class="">
            <a href="/">All projects</a>
        </div>
    <?php endif; ?>
    <h1>
        <?= $project->name ?> Timeline
    </h1>
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
    <script src="/public/js/app.js"></script>
</body>
</html>
