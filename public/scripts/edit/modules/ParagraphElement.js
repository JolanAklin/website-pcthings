import { Element } from "./Element.js";

export function Paragraph(idPosition) {
  this.addPositionNode = document.getElementById(idPosition);
  this.mainDiv = document.createElement("DIV");
  this.mainTextDiv = document.createElement("DIV");

  const CreateElement = (ev) => {
    // create a text element to display the element name
    var infoText = document.createElement("P");
    infoText.className = "page-element-info-text";
    infoText.innerHTML = "Paragraph";
    this.mainDiv.appendChild(infoText);

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

  /*
  Paragraph.prototype.ToHtml = function () {
    var contentDivs = Array.from(this.mainTextDiv.getElementsByTagName("DIV"));
    var content;
    if (contentDivs.length == 0) {
      content = this.mainTextDiv.textContent;
    } else {
      contentDivs.forEach((element) => {
        content += element.textContent + "</br>";
      });
    }

    var div = document.createElement("DIV");
    var titleforhtml = document.createElement("H2");
    titleforhtml.innerHTML = this.titleDiv.textContent;
    div.appendChild(titleforhtml);
    var p = document.createElement("P");
    p.innerHTML = content;
    div.appendChild(p);
    return div;
  };
  */

  CreateElement();
}

Paragraph.prototype = new Element();
