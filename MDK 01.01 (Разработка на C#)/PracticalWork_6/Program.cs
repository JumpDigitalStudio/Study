using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MDKCONSOLEAPP
{
    // Работу выполнил студент группы 4ПК2 Кузнецов Илья Владиславович

    internal class Program
    {
        static void Main(string[] args)
        {
            // ЗАДАНИЕ 1
            // Создайте функцию, печатающую все возможные представления натурального числа
            // N в виде суммы других натуральных чисел.

            // Создаем и заполняем значение натурального числа
            Console.Write("Введите натуральное число: ");
            int N = Convert.ToInt32(Console.ReadLine());

            NaturalNumber(N, 1);

            // Итог проверки
            if (IsPrime(N))
                Console.WriteLine("Число является простым");
            else
                Console.WriteLine("Число не является простым");

            // Создаем и заполняем значение строки
            Console.Write("Введите строку: ");
            string str = Console.ReadLine().ToLower();

            // Итог проверки
            if (isPalindrom(str, 0))
                Console.WriteLine("Строка является палиндромом");
            else
                Console.WriteLine("Строка не является палиндромом");

            // Заполняем значение строки
            Console.Write("Введите строку: ");
            str = Console.ReadLine().ToLower();

            // Итог проверки
            if (checkBrackets(str))
                Console.WriteLine("Скобки расставлены правильно");
            else
                Console.WriteLine("Скобки расставлены неправильно");
                Console.ReadLine();
        }

        // Проверка натурального числа
        public static void NaturalNumber(int N, int i)                   
        {
            if (isNature(N))                                             
            {
                int k = N - i;

                if (i <= k)
                {
                    Console.WriteLine(N + " = " + i + " + " + k);
                    NaturalNumber(N, i + 1);
                }
            }
            else
                Console.WriteLine("Число не является натуральным");
        }

        // Проверка на натуральность
        static bool isNature(int N)                                   
        {
            if (N >= 1 && N % 1 == 0)
                return true;
            else
                return false;
        }

        // Проверка простого числа
        static bool IsPrime(int n, int k = 2)                           
        {
            if (k * k > n)
                return true;
            if (n % k == 0)
                return false;
            return IsPrime(n, k + 1);
        }

        // Проверка на палиндром
        static bool isPalindrom(string str, int i)                      
        {
            if (str[i] != str[str.Length - i - 1])
                return false;

            if (i <= str.Length / 2 - 1)
                isPalindrom(str, i + 1);

            return true;
        }

        // Проверка на расстановку строк
        static bool checkBrackets(string str)                           
        {
            int left = str.IndexOf("(");
            int right = str.LastIndexOf(")");

            if (left == -1 && right == -1)
                return true;
            else if (left == -1 || right == -1 || right < left)
                return false;
            else
                try
                {
                    return checkBrackets(str.Substring(left + 1, right));
                }
                catch (System.ArgumentOutOfRangeException)
                {
                    return false;
                }
        }
    }
}
