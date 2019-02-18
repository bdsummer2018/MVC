<h1><?=$hh?></h1>
<table>
    <tr>
        <th>name</th>
        <th>year</th>
        <th>author</th>
    </tr>
<?php foreach ($films as $film):?>
    <tr>
        <td><?=$film->name?></td>
        <td><?=$film->year?></td>
        <td><?=$film->user()->login?></td>
    </tr>
<?php endforeach;?>
</table>
<h2>-!!!!!!!!!!!!!!!!!!-</h2>
<h1><?=$hh?></h1>
<table>
    <tr>
        <th>name</th>
        <th>year</th>
        <th>author</th>
    </tr>
    <?php foreach ($films2 as $film):?>
        <tr>
            <td><?=$film->name?></td>
            <td><?=$film->year?></td>
            <td><?=$film->user()->login?></td>
        </tr>
    <?php endforeach;?>
</table>