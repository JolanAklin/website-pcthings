import React from "react";
const DefaultElement = (props) => <p {...props.attributes}>{props.children}</p>;

//used to defin custom formatting
const Leaf = (props) => (
  <span
    {...props.attributes}
    style={{
      fontWeight: props.leaf.bold ? "bold" : "normal",
      color: props.leaf.color ? props.leaf.color : "white",
      fontStyle: props.leaf.italic ? "italic" : "normal",
      textDecoration: props.leaf.underlined
        ? "underline"
        : "none currentcolor solid",
    }}
  >
    {props.children}
  </span>
);
export { DefaultElement, Leaf };
