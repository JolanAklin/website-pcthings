import { Element } from "./Element.js";

export function Table(idPosition, id, destroyFunction, moveElement) {
  console.log("hello");
  this.id = idPosition;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.contentDiv = document.createElement("DIV");
  this.buttonsDiv = document.createElement("DIV");
  this.table = document.createElement("table");
  //2d array containing data by row and after by column
  this.currentContent = [["test"]]
  const createElement = (ev) => {
    console.log("create");
    this.mainDiv.appendChild(
      Element.prototype.CreateHeader(
        "Table",
        this.id,
        this.destroyFunction,
        this.mainDiv,
        moveElement
      )
    ); 
    this.mainDiv.className = "page-element";
    this.contentDiv.className = "page-element-input input-content";
    this.buttonsDiv.classname= "v-container"
    const b1 = document.createElement("button");
    b1.textContent = "Add row";
    const b2 = document.createElement("button");
    b2.textContent = "Add column";
    this.buttonsDiv.appendChild(b1);
    this.buttonsDiv.appendChild(b2);

    this.table.className = "input-table";
    let tr = document.createElement("tr");
    let td = document.createElement("td");
    td.textContent = "1";
    tr.appendChild(td);
    this.table.appendChild(tr);

    this.contentDiv.appendChild(this.buttonsDiv);
    this.contentDiv.appendChild(this.table);

    this.mainDiv.appendChild(this.contentDiv);
    this.addPositionNode.appendChild(this.mainDiv)
  };
  Table.prototype.ToJson = function () {
    let gridsNumber = this.gridsNumber.textContent;
    return { Type: "Table", Content: content}
  }
  Table.prototype.FromJson = function(json) {
    this.gridsNumber.textContent = json.Content[0].gridsNumber;
  }
  createElement();
}

Table.prototype = new Element();
