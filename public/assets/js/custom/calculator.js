
document.addEventListener("DOMContentLoaded", function () {
    const display = document.getElementById("display");
    let currentExpression = "";


    function buttonClickHandler(event) {
      const buttonValue = event.target.innerText;


      if (buttonValue === "C") {
        currentExpression = "";
      }

      else if (buttonValue === "⌫") {
        currentExpression = currentExpression.slice(0, -1);
      }

      else if (buttonValue === "=") {
        try {
          currentExpression = calculate(currentExpression).toString();
        } catch {
          currentExpression = "Error";
        }
      }

      else if (buttonValue === "√") {
        if (!currentExpression) {
          currentExpression = "Error";
        } else {
          currentExpression = Math.sqrt(parseFloat(currentExpression)).toString();
        }
      }

      else if (buttonValue === "x²") {
        if (!currentExpression) {
          currentExpression = "Error";
        } else {
          currentExpression = Math.pow(parseFloat(currentExpression), 2).toString();
        }
      }

      else {

        if (currentExpression === "Error") {
          currentExpression = "";
        }
        currentExpression += buttonValue;
      }


      display.value = currentExpression;
    }


    function calculate(expression) {

      expression = expression
        .replace(/×/g, "*")
        .replace(/÷/g, "/")
        .replace(/−/g, "-");


      try {
        const result = Function(`return (${expression})`)();
        if (result === Infinity || result === -Infinity || isNaN(result)) {
          throw new Error("Math Error");
        }
        return result;
      } catch {
        return "Error";
      }
    }


    const calculatorButtons = document.querySelectorAll(".button-row button");
    calculatorButtons.forEach(button => {
      button.addEventListener("click", buttonClickHandler);
    });
  });
