document.addEventListener("DOMContentLoaded", function() {
    var radioButtons = document.querySelectorAll(".rb");
    var labels = document.querySelectorAll(".rl");
  
    radioButtons.forEach(function(button) {
      button.addEventListener("change", function() {
        // クリックされたラジオボタンのラベルの背景色を変更
        if (button.checked) {
          // 他のラベルの背景色をリセット
          labels.forEach(function(label) {
            label.style.backgroundColor = "";
          });
          // クリックされたラジオボタンに対応するラベルの背景色を変更
          var label = document.querySelector("label[for='" + button.id + "']");
          label.style.backgroundColor = "green";
        }
      });
    });
  });


