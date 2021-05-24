import { Element } from "./Element.js";

export function Title(idPosition) {
  this.addPositionNode = document.getElementById(idPosition);
  this.mainDiv = document.createElement("DIV");
  this.title = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.className = "title";
    this.title.contentEditable = true;
    this.title.className = "input";
    this.mainDiv.appendChild(this.title);
    this.addPositionNode.appendChild(this.mainDiv);
  };

  Title.prototype.ToJson = function () {
    var content = this.title.textContent;
    return { Title: { content: content } };
  };

  Title.prototype.ToHtml = function () {
    var content = this.title.textContent;
    var titleHtml = document.createElement("H1");
    titleHtml.innerHTML = content;
    return titleHtml;
  };

  CreateElement();
}

Title.prototype = new Element();
