using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TreeKuznetsov
{
    public class TreeNode
    {
        // Инфо + ссылки на поддеревья
        // ===========================
        private char info;
        private TreeNode left;
        private TreeNode right;

        // Свойства
        // ===========================
        public int Info { get; set; }
        public TreeNode Left { get; set; }
        public TreeNode Right { get; set; }

        // Конструкторы
        // ===========================
        public TreeNode() { } 
        public TreeNode(int info)
        {
            Info = info;
        }
        public TreeNode(int info, TreeNode left, TreeNode right)
        {
            Info = info; Left = left; Right = right;
        }
    }

    public class BinaryTree
    {
        // Ссылка на корень дерева
        // ===========================
        private TreeNode root;
        public TreeNode Root
        {
            get { return root; }
            set { root = value; }
        }

        // Создание пустого дерева
        // ===========================
        public BinaryTree()
        {
            root = null;
        }


        /// <summary>
        /// Метод построения сбалансированного дерева из N узлов 
        /// </summary>
        /// <param name="n"></param>
        /// <returns></returns>
        public TreeNode Create_Balanced(int n)
        {
            int x;
            TreeNode root;
            if (n == 0)
                root = null;
            else
            {   // Заполнение поля корня  
                Console.WriteLine("Значение поля узла (символ):");
                x = int.Parse(Console.ReadLine());
                // Создать корень дерева  
                // ===========================
                root = new TreeNode(x);
                // Построить левое поддерево (*1*)
                root.Left = Create_Balanced(n / 2);
                // Построить правое поддерево  (*2*)
                root.Right = Create_Balanced(n - n / 2 - 1);
            }
            return root; //(*3*)
        }

        /// <summary>
        /// 
        /// </summary>
        /// <param name="root"></param>
        public void KLP(TreeNode root) 
        {
            // Проверка пустоты
            // ===========================
            if (root != null)
            {
                // Вывести поле корневого узла  
                // ===========================
                Console.WriteLine(root.Info);
                // (*1*)обойти левое поддерево в нисходящем порядке  
                KLP(root.Left);
                // (*2*)обойти правое поддерево в нисходящем порядке 
                KLP(root.Right); 
            }
            //(* 3 *) 
        }
    }
}
