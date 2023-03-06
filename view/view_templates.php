<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $tricount->title ?> &#11208; Templates</title>
    <base href="<?= $web_root ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="main">
        <header class="t2">
            <a href="tricount/edit_tricount/<?= $tricount->id ?>" class="button" id="back">Back</a>
            <p><?= strlen($tricount->title) > 20 ? substr($tricount->title, 0, 20)."..." : $tricount->title ?> &#11208; Templates</p>
            <a href="templates/add_template/<?= $tricount->id ?>" class="button" id="add">Add</a>
        </header>
        <?php if (empty($templates)) { ?>
            <table>
                <tr>
                    <th class="empty">Currently no Templates !</th>
                </tr>
                <tr>
                    <td class="empty">
                        <p>Click below to add a Template!</p>
                        <a href="templates/add_template/<?= $tricount->id ?>" class="button">Add Template</a>
                    </td>
                </tr>
            </table>
        <?php } else { ?>
            <table>
                <?php
                for ($cpt = 0; $cpt != count($templates); $cpt++) { ?>
                    <tr>
                        <td>
                            <a href="templates/edit_template/<?= $tricount->id ?>/<?= $templates[$cpt]->id ?>">
                                <h3><?= strlen($templates[$cpt]->title) > 25 ? substr($templates[$cpt]->title, 0, 25)."..." : $templates[$cpt]->title ?></h3>
                            </a>
                            <ul>
                                <?php
                                foreach ($all_templates_items_for_view[$cpt] as $nom => $poids) { ?>
                                    <li class="listyle">
                                    <?= strlen($nom . ' (' . $poids . '/' . $all_weight_total[$cpt] . ')') > 30 ? substr($nom, 0, 25)."... (" . $poids . '/' . $all_weight_total[$cpt] . ')' : $nom . ' (' . $poids . '/' . $all_weight_total[$cpt] . ')' ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </td>
                    </tr>
            <?php }
            } ?>
            </table>
    </div>
</body>

</html>