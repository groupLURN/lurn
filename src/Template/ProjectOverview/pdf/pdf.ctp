<br>
<br>
<p>
This is to certify that work by the contract: <b><?= $project->title ?></b> located at <?= $project->location ?> has been completed as of  has been completed as of <?= date_format($project->modified, 'F d, Y') ?>.
</p>

<p>
This certificate also serves as formal turn-over of the <b><?= $project->title ?></b> to <b><?= $project->client->company_name ?></b> in compliance with the terms and obligations specified in the contract.
</p>

<p>
J.I. ESPINO CONSTRUCTION guarantees the works and materials furnished under the contract for a period of twelve (12) months after the issuance of this Certificate of Completion, effective <?= date_format($project->modified, 'F d, Y') ?>. The guarantee period shall therefore be up to <?= date_format($project->guarantee, 'F d, Y') ?>.
</p>
