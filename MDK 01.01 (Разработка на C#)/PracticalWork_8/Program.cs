using System;

namespace TreeKuznetsov
{
    // Практическая работа 8
    // Работа со сбалансированным деревом
    // Выполнил студент группы 4ПК2
    // Кузнецов Илья Владиславович
    // ==================================

    internal class Program
    {
        static void Main(string[] args)
        {
            BinaryTree T = new BinaryTree();
            Console.WriteLine("Количество узлов: ");
            T.Root = T.Create_Balanced(Convert.ToInt32(Console.ReadLine()));

            GetMean Solution = new GetMean();
            Console.WriteLine("Среднее арифметическое значений полей узлов дерева: " + Solution.InorderTraversal(T.Root));

            SignCount count = new SignCount();
            count.Counting(T.Root);
            Console.WriteLine("Кол-во положительных значений: " + count.plusCount);
            Console.WriteLine("Кол-во отрицательных значений: " + count.minusCount);

            Console.WriteLine("Введите искомое значение: ");
            int value = Convert.ToInt32(Console.ReadLine());
            Search search = new Search();
            Console.WriteLine("Найдено совпадений: " + search.SearchValue(T.Root, value));
            Console.ReadLine();
        }
    }
}
