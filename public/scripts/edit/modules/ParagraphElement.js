import { Element } from "./Element.js";

export function Paragraph(idPosition, id, destroyFunction, moveElement) {
  this.id = id;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.mainTextDiv = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.appendChild(Element.prototype.CreateHeader("Paragraph", this.id, this.destroyFunction, this.mainDiv, moveElement));

    this.mainDiv.className = "page-element input-paragraph";
    this.mainTextDiv.className = "page-element-input input-paragraph";
    this.mainTextDiv.contentEditable = true;
    this.mainDiv.appendChild(this.mainTextDiv);

    this.addPositionNode.appendChild(this.mainDiv);
  };

  Paragraph.prototype.ToJson = function () {
    var contentDivs = Array.from(this.mainTextDiv.getElementsByTagName("DIV"));
    var content = "";
    // loop throught all the divs inside the text div to put the text in the right format
    if (contentDivs.length == 0) {
      content = this.mainTextDiv.textContent;
    }else {
      contentDivs.forEach((element) => {
        console.log(element.textContent);
        content += encodeURIComponent(element.textContent + "\n");
      });
    }
    return { Type:"p", Content: content };
  };

  Paragraph.prototype.FromJson = function (json) {
    var contentString = decodeURIComponent(json.Content);
    var contentStringSplit = contentString.split("\n");
    contentStringSplit.pop();
    contentStringSplit.forEach(element => {
      var div = document.createElement("DIV");
      div.textContent = element;
      this.mainTextDiv.appendChild(div);
    });
  };

  CreateElement();
}

Paragraph.prototype = new Element();
