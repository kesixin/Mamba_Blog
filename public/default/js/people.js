//右键菜单
jQuery(document).ready(function ($) {
  $("body").append('<div id="spig" class="spig"><div id="message"></div><div id="mumu"class="mumu"></div></div>').mousedown(function (e) {
    if (e.which == 3) {
      showMessage("告诉你一个秘密，我家主人是单身哦！", 10000);
    }
  }).bind("contextmenu", function (e) {
    return false;
  });
  $("#message").hover(function () {
    $("#message").fadeTo("100", 1);
  });
//鼠标在上方时
  $(".mumu").mouseover(function () {
    $(".mumu").fadeTo("300", 0.3);
    msgs = ["我隐身了，你看不到我", "我会隐身哦！嘿嘿！", "别动手动脚的，把手拿开！", "把手拿开我才出来！"];
    var i = Math.floor(Math.random() * msgs.length);
    showMessage(msgs[i]);
  }).mouseout(function () {
    $(".mumu").fadeTo("300", 1)
  });

//开始

  if (isindex) { //如果是主页
    var now = (new Date()).getHours();
    if (now > 0 && now <= 6) {
      showMessage(visitor + ' 你是夜猫子呀？还不睡觉，明天起的来么你？', 6000);
    } else if (now > 6 && now <= 11) {
      showMessage(visitor + ' 早上好，早起的鸟儿有虫吃噢！早起的虫儿被鸟吃，你是鸟儿还是虫儿？嘻嘻！', 6000);
    } else if (now > 11 && now <= 14) {
      showMessage(visitor + ' 中午了，吃饭了么？不要饿着了，饿死了谁来挺我呀！', 6000);
    } else if (now > 14 && now <= 18) {
      showMessage(visitor + ' 下午的时光真难熬！还好有你在！', 6000);
    } else {
      showMessage(visitor + ' 快来逗我玩吧！', 6000);
    }
  }
  // else {
  //   showMessage('欢迎' + visitor + '来到Falost的小窝阅读《' + title + '》', 6000);
  // }
  $(".spig").animate({
        top: $(".spig").offset().top + 350,
        left: document.body.offsetWidth - 160
      },
      {
        queue: false,
        duration: 1000
      });

//鼠标在某些元素上方时

  $('#menu-item-362').click(function () {
    showMessage('主人如果写的不好，可以指点指点哦！')
  }).mousemove(function () {
    showMessage('这里是我家主人写的一些小 Demo 哦，不妨进去看看！')
  });
  $('h2 a').click(function () {//标题被点击时
    showMessage('正在用吃奶的劲加载《<span style="color:#0099cc;">' + $(this).text() + '</span>》请稍候');
  }).mouseover(function () {
    showMessage('要看看《<span style="color:#0099cc;">' + $(this).text() + '</span>》这篇文章么？');
  });
  $('.blogroll li a').mouseover(function () {
    showMessage('去 <span style="color:#0099cc;">' + $(this).text() + '</span> 逛逛');
  });
  $('#ct').mouseover(function () {
    showMessage('<span style="color:#0099cc;">' + visitor + '</span> 向评论栏出发吧！');
  });
  $('#submit').mouseover(function () {
    showMessage('确认提交了么？');
  });
  $('.toggle-search').mousemove(function () {
    showMessage('输入你想搜索的关键词再按Enter(回车)键就可以搜索啦!');
  });
  $('#menu-item-19').mouseover(function () {
    showMessage('点它就可以回到首页啦！');
  });
  $('#Addlike').mouseover(function () {
    showMessage('怎么点击下，支持下我家小主人吧！');
  });
  $('.nav li a').mouseover(function () {
    showMessage('点击查看此分类下得所有文章');
  });
  $('.btn-inverse .icon-eject').mouseover(function () {
    showMessage('点它可以返回网页最顶端.');
  });
  $('#tho-shareto span a').mouseover(function () {
    showMessage('你知道吗?点它可以分享本文到' + $(this).attr('title'));
  });
  $('#shang-main-p').mouseover(function () {
    showMessage('点这里可以打赏我家小主人哦，快拿出支付宝赏一个吧！');
  });

//无聊讲点什么

  window.setInterval(function () {
    msgs = ["播报现在天气<iframe name=\"xidie\" src=\"http://blog.wanghaida.com/static/spig/tianqi.html\" frameborder=\“0\” scrolling=\"no\" height=\"26px\"  width=\"135px\" allowtransparency=\"true\" ></iframe>", "陪我聊天吧！", "右击有惊喜哦！", "好无聊哦，你都不陪我玩！", "…@……!………", "^%#&*!@*(&#)(!)(", "我可爱吧！嘻嘻!~^_^!~~", "谁淫荡呀?~谁淫荡?，你淫荡呀!~~你淫荡！~~", "从前有座山，山上有座庙，庙里有个老和尚给小和尚讲故事，讲：“从前有座……”"];
    var i = Math.floor(Math.random() * msgs.length);
    showMessage(msgs[i], 10000);
  }, 35000);


//无聊动动

  window.setInterval(function () {
    msgs = ["乾坤大挪移！", "我飘过来了！~", "我飘过去了", "我得意地飘！~飘！~"];
    var i = Math.floor(Math.random() * msgs.length);
    s = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.75, -0.1, -0.2, -0.3, -0.4, -0.5, -0.6, -0.7, -0.75];
    var i1 = Math.floor(Math.random() * s.length);
    var i2 = Math.floor(Math.random() * s.length);
    $(".spig").animate({
          left: document.body.offsetWidth / 2 * (1 + s[i1]),
          top: document.body.offsetheight / 2 * (1 + s[i1])
        },
        {
          duration: 2000,
          complete: showMessage(msgs[i])
        });
  }, 45000);


//评论资料

  $("#author").click(function () {
    showMessage("留下你的尊姓大名！");
    $(".spig").animate({
          top: $("#author").offset().top - 70,
          left: $("#author").offset().left + 370
        },
        {
          queue: false,
          duration: 1000
        });
  });
  $("#email").click(function () {
    showMessage("留下你的邮箱，不然就是无头像人士了！");
    $(".spig").animate({
          top: $("#email").offset().top - 70,
          left: $("#email").offset().left + 370
        },
        {
          queue: false,
          duration: 1000
        });
  });
  $("#url").click(function () {

    showMessage("快快告诉我你的家在哪里，好让我去参观参观！");
    $(".spig").animate({
          top: $("#url").offset().top - 70,
          left: $("#url").offset().left + 370
        },
        {
          queue: false,
          duration: 1000
        });
  });
  $("#comment").click(function () {
    showMessage("认真填写哦！不然会被认作垃圾评论的！我的乖乖~");
    $(".spig").animate({
          top: $("#comment").offset().top - 70,
          left: $("#comment").offset().left + 370
        },
        {
          queue: false,
          duration: 1000
        });
  });

  var spig_top = 50;

  //滚动条移动

  var f = $(".spig").offset().top;
  $(window).scroll(function () {
    $(".spig").animate({
          top: $(window).scrollTop() + f + 300
        },
        {
          queue: false,
          duration: 1000
        });
  });


  //鼠标点击时

  var stat_click = 0;
  $(".mumu").click(function () {
    if (!ismove) {
      stat_click++;
      if (stat_click > 4) {
        msgs = ["你有完没完呀？", "你已经摸我" + stat_click + "次了", "非礼呀！救命！OH，My ladygaga"];
        var i = Math.floor(Math.random() * msgs.length);
        //showMessage(msgs[i]);
      } else {
        msgs = ["筋斗云！~我飞！", "我跑呀跑呀跑！~~", "别摸我，大男人，有什么好摸的！", "惹不起你，我还躲不起你么？", "不要摸我了，我会告诉你老婆来打你的！", "干嘛动我呀！小心我咬你！"];
        var i = Math.floor(Math.random() * msgs.length);
        //showMessage(msgs[i]);
      }
      s = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.75, -0.1, -0.2, -0.3, -0.4, -0.5, -0.6, -0.7, -0.75];
      var i1 = Math.floor(Math.random() * s.length);
      var i2 = Math.floor(Math.random() * s.length);
      $(".spig").animate({
            left: document.body.offsetWidth / 2 * (1 + s[i1]),
            top: document.body.offsetheight / 2 * (1 + s[i1])
          },
          {
            duration: 500,
            complete: showMessage(msgs[i])
          });
    } else {
      ismove = false;
    }
  });
});
//显示消息函数
function showMessage(a, b) {
  if (b == null) b = 10000;
  jQuery("#message").hide().stop().html(a).fadeIn().fadeTo("1", 1).fadeOut(b);
}

//拖动
var _move = false;
var ismove = false; //移动标记
var _x, _y; //鼠标离控件左上角的相对位置
jQuery(document).ready(function ($) {
  $("#spig").mousedown(function (e) {
    _move = true;
    _x = e.pageX - parseInt($("#spig").css("left"));
    _y = e.pageY - parseInt($("#spig").css("top"));
  });
  $(document).mousemove(function (e) {
    if (_move) {
      var x = e.pageX - _x;
      var y = e.pageY - _y;
      var wx = $(window).width() - $('#spig').width();
      var dy = $(document).height() - $('#spig').height();
      if (x >= 0 && x <= wx && y > 0 && y <= dy) {
        $("#spig").css({
          top: y,
          left: x
        }); //控件新位置
        ismove = true;
      }
    }
  }).mouseup(function () {
    _move = false;
  });
});
