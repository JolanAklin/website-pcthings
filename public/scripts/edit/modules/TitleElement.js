import { Element } from "./Element.js";

export function Title(idPosition, id, destroyFunction) {
  this.id = id;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.title = document.createElement("DIV");

  const CreateElement = (ev) => {
    this.mainDiv.appendChild(Element.prototype.CreateHeader("Title", this.id, this.destroyFunction, this.mainDiv));

    this.mainDiv.className = "page-element input-title";
    this.title.contentEditable = true;
    this.title.className = "page-element-input input-title";
    this.mainDiv.appendChild(this.title);
    this.addPositionNode.appendChild(this.mainDiv);
  };

  Title.prototype.ToJson = function () {
    var content = this.title.textContent;
    return { Type:"h", Content: content };
  };

  /*
  Title.prototype.ToHtml = function () {
    var content = this.title.textContent;
    var titleHtml = document.createElement("H1");
    titleHtml.innerHTML = content;
    return titleHtml;
  };
  */

  CreateElement();
}

Title.prototype = new Element();
