<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Recipient> $recipients
 * @var mixed $q
 */
?>
<div>
    <div class="d-flex justify-content-between">
        <div>
            <h1>Recipients</h1>
            <p>A list of all recipients.</p>
        </div>
        <div>
            <?= $this->Html->link(
				'Add Recipient',
				['action' => 'add'],
				['class' => 'btn btn-outline-primary mt-2'],
			) ?>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <?= $this->Form->create(null, [
			'type' => 'get',
			'class' => 'd-flex gap-3',
		]) ?>
            <?= $this->Form->input('q', [
				'type' => 'search',
				'label' => 'Search',
				'id' => 'search',
				'value' => $q,
				'hx-get' => $this->Url->build(['action' => 'index']),
				'hx-trigger' => 'search, keyup delay:200ms changed',
				'hx-target' => 'tbody',
				'hx-swap' => 'outerhtml',
				'hx-push-url' => 'true',
				'hx-indicator' => '#spinner',
			]) ?>
            <?= $this->Form->submit('Search', [
				'class' => 'btn btn-outline-primary',
			]) ?>
        <?= $this->Form->end() ?>
        <div id="spinner" class="spinner-border htmx-indicator" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div>
        <div>
            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Address</th>
                        <th scope="col">Created</th>
                        <th scope="col">Modified</th>
                        <th scope="col">
                            <span class="visually-hidden">Edit or View</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <?= $this->element('Admin/Recipients/list') ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
