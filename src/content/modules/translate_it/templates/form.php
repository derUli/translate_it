<?php
$translations = ViewBag::get("translations");
if ($translations) {
    ?>
    <form
        action="<?php
        echo ModuleHelper::buildAdminURL(
        $module,
        "sClass=TranslateItController&sMethod=downloadFile"
    ); ?>"
        method="post">
            <?php csrf_token_html(); ?>
        <div class="scroll">
            <table>
                <thead>
                <th style="width: 30%;">
                    <?php translate("title"); ?>
                </th>
                <th style="width: 70%;">
                    <?php translate("translation"); ?>
                </th>
                </thead>
                <tbody>
                    <?php foreach ($translations as $key => $value) { ?>
                        <tr>
                            <td style="width: 30%">
                                <?php esc($key); ?>
                            </td>
                            <td style="width: 70%;">
                                <input
                                    type="text"
                                    name="<?php esc($key); ?>"
                                    value="<?php esc($value); ?>"
                                    >
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row voffset3">
            <div class="col-xs-8">
                <div class="row">
                    <div class="col-xs-4">
                        <strong><?php translate("language_code"); ?></strong>
                    </div>
                    <div class="col-xs-8">
                        <input
                            type="text"
                            name="language_code"
                            required
                            value="<?php esc(getCurrentLanguage()); ?>"
                        >
                    </div>
                </div>
            </div>
            <div class="col-xs-4 text-right">
                <button type="submit" class="btn btn-primary">
                    <?php translate("generate_language_file"); ?>
                </button>
            </div>
        </div>
    </form>
<?php
}
