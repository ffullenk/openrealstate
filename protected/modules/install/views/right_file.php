<h2><?php echo tFile::getT('module_install', 'Necessary parameters for the Open Real Estate CMS installation');?></h2>
<table class="result">
    <tr>
        <th><?php echo tFile::getT('module_install', 'Directory/file'); ?></th>
        <th><?php echo tFile::getT('module_install', 'Comment'); ?></th>
    </tr>
    <?php foreach ($aCheckDirErr['dirs'] as $sDirPath => $sRes): ?>
    <tr>
        <td width="60%"><?php echo $sDirPath; ?></td>
        <td class="<?php echo ($sRes == 'ok') ? 'passed' : 'failed'; ?>">
            <?php echo ($sRes == 'ok') ? 'ОК' : $sRes; ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>