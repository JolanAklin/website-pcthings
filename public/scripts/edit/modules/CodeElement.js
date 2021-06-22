import { Element } from "./Element.js";

export function Code(idPosition, id, destroyFunction, moveElement) {
  this.id = id;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.codeTitle = document.createElement("DIV");
  this.mainTextDiv = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.appendChild(
      Element.prototype.CreateHeader(
        "Code title",
        this.id,
        this.destroyFunction,
        this.mainDiv,
        moveElement
      )
    );

    this.mainDiv.className = "page-element input-code";
    this.codeTitle.className = "page-element-input input-code-title";
    this.codeTitle.contentEditable = true;
    this.mainDiv.appendChild(this.codeTitle);

    var infoText = document.createElement("P");
    infoText.className = "page-element-info-text";
    infoText.innerHTML = "Code";
    this.mainDiv.appendChild(infoText);

    this.mainTextDiv.className = "page-element-input input-code";
    this.mainTextDiv.contentEditable = true;
    this.mainDiv.appendChild(this.mainTextDiv);

    this.addPositionNode.appendChild(this.mainDiv);
  };

  Code.prototype.ToJson = function () {
    var contentDivs = Array.from(this.mainTextDiv.getElementsByTagName("DIV"));
    var content = "";
    // loop throught all the divs inside the text div to put the text in the right format
    if (contentDivs.length == 0) {
      content = this.mainTextDiv.textContent;
    } else {
      var i = 0;
      contentDivs.forEach((element) => {
        console.log(element.textContent);
        if (i == contentDivs.length - 1)
          content += encodeURIComponent(element.textContent);
        else content += encodeURIComponent(element.textContent + "\n");
        i += 1;
      });
    }
    return {
      Type: "code",
      Content: [{ Title: this.codeTitle.textContent }, { Content: content }],
    };
  };

  Code.prototype.FromJson = function (json) {
    this.codeTitle.textContent = json.Content[0].Title;

    var contentString = decodeURIComponent(json.Content[1].Content);
    var contentStringSplit = contentString.split("\n");
    contentStringSplit.forEach((element) => {
      var div = document.createElement("DIV");
      div.textContent = element;
      this.mainTextDiv.appendChild(div);
    });
  };

  CreateElement();
}

Code.prototype = new Element();
