<div class="first">
    <p> Okay lets see ... </p>
    <p> Today you used <?php echo $global_energy_total_data; ?> KWH of energy. </p>
    <div>
    <p> This means you got <span class="euro-value" style="color:#01ff00;"><?php echo number_format((float)$global_energy_total_data * 0.3, 2, '.', ''); ?> €</span> from the government!</p>
</div>

<div class="second"><p> This will be the second text </p> </div>
<div class="third"><p> This will be the third text </p> </div>
<div class="fourth"><p> This will be the fourth text </p> </div>
