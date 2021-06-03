import { Element } from "./Element.js";

export function Title2(idPosition) {
  this.addPositionNode = document.getElementById(idPosition);
  this.mainDiv = document.createElement("DIV");
  this.title = document.createElement("DIV");

  const CreateElement = (ev) => {
    // create a text element to display the element name
    var infoText = document.createElement("P");
    infoText.className = "page-element-info-text";
    infoText.innerHTML = "Title";
    this.mainDiv.appendChild(infoText);


    this.mainDiv.className = "page-element input-title2";
    this.title.contentEditable = true;
    this.title.className = "page-element-input input-title2";
    this.mainDiv.appendChild(this.title);
    this.addPositionNode.appendChild(this.mainDiv);
  };

  Title2.prototype.ToJson = function () {
    var content = this.title.textContent;
    return { Type:"h2", Content: content };
  };

  /*
  Title2.prototype.ToHtml = function () {
    var content = this.title.textContent;
    var titleHtml = document.createElement("H1");
    titleHtml.innerHTML = content;
    return titleHtml;
  };
  */

  CreateElement();
}

Title2.prototype = new Element();
