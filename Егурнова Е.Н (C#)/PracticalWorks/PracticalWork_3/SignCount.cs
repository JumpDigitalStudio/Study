using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TreeKuznetsov
{
    // Подсчёт положительных и отрицательных значений
    // ==============================================

    public class SignCount
    {
        public int plusCount = 0;
        public int minusCount = 0;
        public void Counting(TreeNode root)
        {
            if (root == null)
                return;

            if (root.Left != null)
                Counting(root.Left);

            if (root.Info >= 0)
                plusCount++;
            else
                minusCount++;

            if (root.Right != null)
                Counting(root.Right);
        }
    }
}
