$(function(){
	//=================收藏==========================
	$('.collect').click(function(){
		if($(this).hasClass('act') == false){
			$(this).addClass('act');
			$(this).attr('src','images/collect1.png');
		}else{
			$(this).removeClass('act');
			$(this).attr('src','images/collect.png');
		}
		
	})
    //================限价与额度=============================		
        $('.limitedprice').click(function(){
            $('#mask1').show();
            $('#Limited>ul>li').eq(0).html('<p>限价</p><p>市价</p>');
            $('#Limited>ul>li>p').eq(0).css('color','#02C289');
            $('#Limited>ul>li>p').click(function(){
                $(this).css('color','#02C289').siblings().css('color','#ccc');
                $('#mask1').hide();
                $('.limitedprice').html($(this).html() +'<img src="images/pulldown.png"/>');	
            })
        });	
        $('.limit').click(function(){
            $('#mask1').show();
            $('#Limited>ul>li').eq(0).html('<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>');
            $('#Limited>ul>li>p').eq(0).css('color','#02C289');            	
            $('#Limited>ul>li>p').click(function(){
                $(this).css('color','#02C289').siblings().css('color','#ccc');	
                $('#mask1').hide();
                $('.limit').html('额度'+ $(this).html()+'<img src="images/pulldown.png"/>');
            });    
        });



        $('.cancel').click(function(){
            $('#mask1').hide(10);
        });
        //==============限价数量===================
        $('.Btc>li').eq(0).find('span').addClass('span').find('i').addClass('cc');
        $('.Btc>li').click(function(){
            $('.absolute').removeClass('span').find('i').removeClass('cc').parent().prev('a').removeClass('back');
            var index = $(this).index();
            $(".Btc>li:lt("+(index+1)+")").find('span').addClass('span').find('i').addClass('cc').parent().prev('a').addClass('back');
        
        });
        
        
        //================BTC====================
        $('.deal>span').eq(0).addClass('bor').find('a').addClass('col').siblings('em').addClass('borl');
        $('.buy').click(function(){
            window.type='buy';
            setlocal_storage('levertype','buy');
            var currency_name = '';
            if(getlocal_storage('lever')){
                currency_name=getlocal_storage('lever').currency_name;
            }
            $('.num span').removeClass('actives');
            $('.num span').removeClass('active');
            $('.multiple_sel span').removeClass('actives');
            $('.multiple_sel span').removeClass('active');
            $('.num span:nth-child(2)').addClass('actives');
            $('.multiple_sel span:first-child').addClass('actives');
            $(this).addClass('bor').find('a').addClass('col').siblings('em').removeClass('borr').addClass('borl').parent().next().removeClass('bor2').find('a').removeClass('col2');
             $('.transactionAmount').find('button').removeClass('activesell').html(buy+'&nbsp'+makemore+currency_name);       
        });
        $('.sell').click(function(){
            $('.num span').removeClass('actives');
            $('.num span').removeClass('active');
            $('.multiple_sel span').removeClass('actives');
            $('.multiple_sel span').removeClass('active');
            $('.multiple_sel span:first-child').addClass('active');
            $('.num span:nth-child(2)').addClass('active');
            window.type='sell';
            setlocal_storage('levertype','sell');
            var currency_name = '';
            if(getlocal_storage('lever')){
                currency_name=getlocal_storage('lever').currency_name;
            }
            $(this).addClass('bor2').find('a').addClass('col2').parent().prev().removeClass('bor').find('a').removeClass('col').siblings('em').removeClass('borl').addClass('borr');
            $('.transactionAmount').find('button').addClass('activesell').html(sell+'&nbsp'+makeless+currency_name)      
        })
        
        //=================买入卖出====================
        var num = Number($('.Price>li').eq(0).html()) ;
        $('.subtract').click(function(){
            num -=1;
            $('.Price>li').eq(0).html(num);
        });
        $('.plus').click(function(){
            num +=1;
            $('.Price>li').eq(0).html(num);
        });	
        
    
    	//==================左侧导航============================
        $('.sideOpen').click(function(){    ``
            $('body').css('overflow','hidden');
            $('#Limited').hide();
            $('#mask1').show();
            $('#sideColumn').animate({
                left:'0px'
            },1000);
        });
        $('.sideclose').click(function(){
            $('body').css('overflow','auto');
            $('#Limited').show();
            $('#mask1').hide();
            $('#sideColumn').animate({
                left:'-80%'
            },1000);
        });
        $('.ul').eq(1).show();
        
    })
    