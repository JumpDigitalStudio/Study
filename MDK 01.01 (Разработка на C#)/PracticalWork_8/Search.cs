using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TreeKuznetsov
{
    // Поиск совпадений по значению
    // ============================
    public class Search
    {
        int result = 0;

        public int SearchValue(TreeNode root, int value)
        {
            if (root == null)
                return result;

            if (root.Left != null)
                SearchValue(root.Left, value);

            if (root.Info == value)
                result++;

            if (root.Right != null)
                SearchValue(root.Right, value);

            return result;
        }
    }
}
