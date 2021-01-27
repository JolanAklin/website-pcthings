import { Editor, Transforms, Text } from "slate";
const CustomEditor = {
  isHeadingActive(editor, num) {
    const [match] = Editor.nodes(editor, {
      match: (n) => n.type === `h${num}`,
    });
    return !!match;
  },
  toggleHeading(editor, num) {
    const isActive = CustomEditor.isHeadingActive(editor, num);
    Transforms.setNodes(
      editor,
      { type: isActive ? null : `h${num}` },
      { match: (n) => Editor.isBlock(editor, n) }
    );
  },
  toggleDefault(editor) {
    Transforms.setNodes(
      editor,
      { type: null },
      { match: (n) => Editor.isBlock(editor, n) }
    );
  },
  isLeafMarkActive(editor, type) {
    const [match] = Editor.nodes(editor, {
      match: (n) => n[type],
      universal: true,
    });
    return !!match;
  },
  toggleLeafMark(editor, type) {
    const isActive = CustomEditor.isLeafMarkActive(editor, type);
    Transforms.setNodes(
      editor,
      { [type]: isActive ? null : true },
      { match: (n) => Text.isText(n), split: true }
    );
  },
};
export default CustomEditor;
