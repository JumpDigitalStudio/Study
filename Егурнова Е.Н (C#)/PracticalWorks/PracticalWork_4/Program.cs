using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_4
{
    class Program
    {
        public class Node
        {
            public int Data { get; set; }
            public Node Left { get; set; }
            public Node Right { get; set; }
            public Node()
            {

            }
            public Node(int data)
            {
                this.Data = data;
            }
        }
        public class BinaryTree
        {
            private Node _root;
            public BinaryTree()
            {
                _root = null;
            }
            public void Insert(int data)
            {
                if (_root == null)
                {
                    _root = new Node(data);
                    return;
                }
                InsertRec(_root, new Node(data));
            }
            private void InsertRec(Node root, Node newNode)
            {

                if (root == null)
                    root = newNode;

                if (newNode.Data < root.Data)
                {
                    if (root.Left == null)
                        root.Left = newNode;
                    else
                        InsertRec(root.Left, newNode);

                }
                else
                {
                    if (root.Right == null)
                        root.Right = newNode;
                    else
                        InsertRec(root.Right, newNode);
                }
            }
            private void DisplayTree(Node root)
            {
                if (root == null) return;

                DisplayTree(root.Left);
                Console.Write(root.Data + " ");
                DisplayTree(root.Right);
            }
            public void DisplayTree()
            {
                DisplayTree(_root);
            }

        }
        static void Main(string[] args)
        {
            Random random = new Random();

            Console.Write("Введите количество информационных полей: ");

            BinaryTree tree = new BinaryTree();
            Node root = new Node();

            int countInfField = int.Parse(Console.ReadLine());
            for (int i = 0; i < countInfField; i++)
            {
                tree.Insert(random.Next(10, 1000));

            }

            tree.DisplayTree();

            Console.ReadKey();
        }
    }
}
