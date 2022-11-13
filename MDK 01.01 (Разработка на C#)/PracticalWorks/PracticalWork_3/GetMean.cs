using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TreeKuznetsov
{
    // Поиск среднего арифметического значения
    // =======================================
    internal class GetMean
    {
        public double InorderTraversal(TreeNode root)
        {
            var sum = 0;
            var count = 0;
            InorderTraversal(root, ref sum, ref count);
            return (double)sum / count;
        }

        private void InorderTraversal(TreeNode root, ref int sum, ref int count)
        {
            if (root == null)
                return;

            if (root.Left != null)
                InorderTraversal(root.Left, ref sum, ref count);

            sum += Convert.ToInt32(root.Info);
            count++;

            if (root.Right != null)
                InorderTraversal(root.Right, ref sum, ref count);
        }
    }
}
