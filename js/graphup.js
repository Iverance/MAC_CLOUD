<script type="text/javascript">
$(document).ready(function() {

    // Here we're "graphing up" only the cells with the "data" class
    $('#your_table td.data').graphup({
        // Define any options here
        colorMap: 'thermometer',
        painter: 'bubbles',
        bubblesDiameter: 80 // px
        // ...
    });

});
</script>

