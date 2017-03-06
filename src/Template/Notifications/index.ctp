
<section >
	<section>

		<div class="apb">
			<h2 class="apc">NOTIFICATIONS</h2>
		</div>
        <div class="row mt">
            <div class="col-xs-12">
                <table class="table table-advance table-hover">
                    <tbody>
                    <?php foreach ($notifications as $notification): ?>
                        <tr>
                            <td>
                                <muted><?= date_format($notification->created, 'F d, Y - g:ia')?></muted>
                                </td>
                            <td><?= $notification->message ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>
</section>




