

<?php


class MessageView{

private $messages;

public function __construct(array $messages){
    $this->messages=$messages;
}

public function render(){
    ob_start();

    ?>
    <hr>

<h2>Contact Messages</h2>

<?php if ($this->messages): ?>
    <?php foreach ($this->messages as $msg): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px">
            <b><?= htmlspecialchars($msg['name']) ?></b> (<?= htmlspecialchars($msg['email']) ?>)<br>

            <?php if ($msg['user_id']): ?>
                <small>User: <b><?= htmlspecialchars($msg['username']) ?></b></small><br>
            <?php else: ?>
                <small>Guest</small><br>
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <small><?= $msg['created_at'] ?></small>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php
return ob_get_clean();

            
}
}?>