/**
 * @package		Codifire
 * @version		1.0
 * @author 		Aldrin Magno <aldrin.magno@digify.com.ph>
 * @copyright 	Copyright (c) 2016, Digify, Inc.
 * @link		http://www.digify.com.ph
 */

jQuery(function($){
    var d = document, ge = 'getElementById';

    $('#target').Jcrop({
        setSelect: [ 175, 100, 400, 300 ]
    });

    // get x,y coordinates and width and height of the crop image
    $('#interface').on('cropmove cropend',function(e,s,c){
        d[ge]('cropx').value = c.x;
        d[ge]('cropy').value = c.y;
        d[ge]('cropw').value = c.w;
        d[ge]('croph').value = c.h;
    });
});


