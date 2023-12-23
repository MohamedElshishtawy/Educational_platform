$(document).ready(function () {
  /** v1.0
   * js file to insert the exam
  */

  // name of exam writer
  function writeName() {
    var name = window.exam_name.value;
    window.nameEx.innerHTML = name;
  }
  $('#exam_name').keyup(function(){
    writeName();
  });
  $('#exam_name').change(function(){
    writeName();
  });


  // add qustion progress
  var 
  valOFinpNum = $('#numOFq'),
  btnAddQ = $('#addQustion'),
  qCounter = 0;


  btnAddQ.click( function(){
    if ( valOFinpNum.val() < "1" ) {
      valOFinpNum.css('color','red');
    } else {
      valOFinpNum.css('color','#5cb85c');

        if ( valOFinpNum.val() > "1" ) {
          var x = 1;
          var wait = setInterval(function() {
            "use stric"
            setOneQustion();
            qCounter++;
            x++
            if ( x > valOFinpNum.val() ) {
              clearInterval(wait);
              valOFinpNum.val(1);
            }
          }, 100);

        } else {
          setOneQustion();
          qCounter++;
        }

      /**
       * FUNCTION -> v2.0
       * function place one qustion
       * it doesn't support parameters
       * ( new vertione [2] ) => adding remove qustion button
       */
      function setOneQustion() {
        "use stric"
        console.log(qCounter)
        // hidden counter && ol counter
        if ( qCounter == 0 && $('#qustionNum').val() == undefined ) {
          // hidden input
          var hidden = document.createElement("INPUT");
          hidden.setAttribute("type","hidden");
          hidden.setAttribute("id","qustionNum");
          hidden.setAttribute("name","qustions_count");
          hidden.setAttribute("value",qCounter+1);
          document.getElementById("ex").appendChild(hidden);

          // ol element
          var ol = document.createElement("OL");
          ol.setAttribute("class","counter-ol");
          ol.setAttribute("id","counterOL");
          document.getElementById("ex").appendChild(ol);
        } else {
          window.qustionNum.setAttribute("value",qCounter+1);
        }
        var hr = document.createElement("HR");
        hr.setAttribute("id",'hr'+qCounter);
        window.counterOL.appendChild(hr);
        // for all div qustion
        var allDiv = document.createElement("DIV");
        allDiv.setAttribute("class","ex-div");
        allDiv.setAttribute("id","qusDiv"+qCounter);
        window.counterOL.appendChild(allDiv);
        // for q num
        var qusNum = document.createElement("LI");
        qusNum.setAttribute("class","q-num");
        qusNum.setAttribute("id","h"+qCounter);
        //qusNum.innerHTML = '<div class="delete-qustion" id ="'+ qCounter +'"><i class="fa fa-times delet"></i>';
        qusNum.innerHTML = '';
        document.getElementById("qusDiv"+qCounter).appendChild(qusNum);
        // for qustion input
        var qInput = document.createElement("TEXTAREA");
        qInput.setAttribute("type","text");
        qInput.setAttribute("class","form-control q-input");
        qInput.setAttribute("id","exInput"+qCounter);
        qInput.setAttribute("placeholder","ضع هنا السؤال");
        qInput.setAttribute("name","q"+qCounter);
        document.getElementById('qusDiv'+qCounter).appendChild(qInput);
        // for qustion image
        var fileInp = document.createElement("INPUT");
        fileInp.setAttribute("type","file");
        fileInp.setAttribute("class","file-input");
        fileInp.setAttribute("id","fileInput"+qCounter);
        fileInp.setAttribute("name","image_for_q_"+qCounter);
        document.getElementById('qusDiv'+qCounter).appendChild(fileInp);
        // for answers inputs
        for ( ans=0;ans<4;ans++ ) {
          var a = document.createElement("INPUT");
          a.setAttribute("type","text");
          a.setAttribute("class","form-control a-input");
          a.setAttribute("id","exInput"+qCounter);
          switch (ans) {
            case 0: a.setAttribute("placeholder","الاجابة الأولى");break;
            case 1: a.setAttribute("placeholder","الاجابة الثانية");break;
            case 2: a.setAttribute("placeholder","الاجابة الثالثة");break;
            case 3: a.setAttribute("placeholder","الاجابة الرابعة");break;
          }
          a.setAttribute("name","a"+ans+qCounter);
          document.getElementById('qusDiv'+qCounter).appendChild(a);
        }
        // for true answer
        var trueTxt = document.createElement("H4");
        trueTxt.setAttribute("class","true-q-txt");
        trueTxt.setAttribute("id","trueTxt"+qCounter);
        trueTxt.innerHTML = "الاجابة الصحيحة هي:"
        document.getElementById('qusDiv'+qCounter).appendChild(trueTxt);
        for ( num=0;num<4;num++ ) {
          var trueAnsDiv = document.createElement("DIV");
          trueAnsDiv.setAttribute("class","true-ans-div");
          trueAnsDiv.setAttribute("id","trueAnsDiv"+qCounter+num);
          document.getElementById('qusDiv'+qCounter).appendChild(trueAnsDiv);

          var radio = document.createElement("INPUT");
          radio.setAttribute("type","radio");
          radio.setAttribute("class","rd-input");
          radio.setAttribute("id","radio"+qCounter+num);
          radio.setAttribute("name","true_for_q_"+qCounter);
          radio.setAttribute("value","a"+num);
          document.getElementById("trueAnsDiv"+qCounter+num).appendChild(radio);

          var label = document.createElement("label");
          label.setAttribute("class","rad-label");
          label.setAttribute("for","radio"+qCounter+num);
          label.setAttribute("id","label"+qCounter+num)
          document.getElementById("trueAnsDiv"+qCounter+num).appendChild(label);

          switch (num) {
            case 0: document.getElementById("label"+qCounter+num).innerHTML = "الاجابة الاولي"; break;
            case 1: document.getElementById("label"+qCounter+num).innerHTML = "الاجابة الثانية"; break;
            case 2: document.getElementById("label"+qCounter+num).innerHTML = "الاجابة الثالثة"; break;
            case 3: document.getElementById("label"+qCounter+num).innerHTML = "الاجابة الرابعة"; break;
          }
        }
        // for qustion obsevation
        var observInp = document.createElement("TEXTAREA");
        observInp.setAttribute("type","text");
        observInp.setAttribute("class","form-control observ-input");
        observInp.setAttribute("id","observInput"+qCounter);
        observInp.setAttribute("placeholder","ضع ملحوظتك علي السؤال");
        observInp.setAttribute("name","observation"+qCounter);
        document.getElementById('qusDiv'+qCounter).appendChild(observInp);
        /* * end the adding */

      }

    }
  } );

  /* end delet qustion btn */

  $('#deleteQustion').click(function(){
    if ( qCounter > 0 ) {
      qCounter--;
      window.qustionNum.value--;
      $('#hr'+qCounter).remove();
      $('#qusDiv'+qCounter).remove();// all div qustion
      $('#h'+qCounter).remove(); // li for qustion number
      $('#exInput'+qCounter).remove(); // text area for qustion
      $('#fileInput'+qCounter).remove(); // image file input
      $('#exInput'+qCounter).remove(); // for 4 answers
      $('#trueTxt'+qCounter).remove(); // for the text "الاجابة الصحيحة هي"
      for ( num=0;num<4;num++ ) { // loop to remove all true ans [div lable radio]
        $('#trueAnsDiv'+qCounter+num).remove(); // for the div
        $('#radio'+qCounter+num).remove(); // for input inener this div
        $('#label'+qCounter+num).remove(); // for label inner this div
      }
      $('#observInput'+qCounter).remove(); // for observation text area

    }
  });
});
