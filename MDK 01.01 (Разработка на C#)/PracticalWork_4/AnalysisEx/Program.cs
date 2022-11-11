using System;
using System.Collections;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Security.AccessControl;
using System.Security.Policy;
using System.Text;
using System.Threading.Tasks;
using Microsoft.VisualBasic.FileIO;

namespace AnalysisEx
{

    internal class Timing
    {
        TimeSpan duration; //хранение результата измерения
        TimeSpan[] threads; // значения времени для всех потоков процесса
        public Timing()
        {
            duration = new TimeSpan(0);
            threads = new TimeSpan[Process.GetCurrentProcess().
            Threads.Count];
        }
        public void StartTime() //инициализация массива threads после вызова сборщика мусора
        {
            GC.Collect();
            GC.WaitForPendingFinalizers();
            for (int i = 0; i < threads.Length; i++)
                threads[i] = Process.GetCurrentProcess().Threads[i].
                UserProcessorTime;
        }
        public void StopTime() //повторный запрос текущего времени и выбирается тот, у которого результат отличается от
        {				//предыдущего
            TimeSpan tmp;
            for (int i = 0; i < threads.Length; i++)
            {
                tmp = Process.GetCurrentProcess().Threads[i].
                UserProcessorTime.Subtract(threads[i]);
                if (tmp > TimeSpan.Zero)
                    duration = tmp;
            }
        }
        public TimeSpan Result()
        {
            return duration;
        }


    }

    internal class Program
    {

        // Работу выполнил студент группы 4ПК2 Кузнецов Илья Владиславович
        // По заданию нужно было реализовать одну из трех сортировок, я реализовал сразу 3, а именно
        // сортировка простым выбором, обменом и шейкер сортировка и сравнил скорость их выполнения
        // для коллекции значений размером более 10.000


        // Сортировка простым выбором
        static int[] SortSelection(int[] mas)
        {

            for (int i = 0; i < mas.Length - 1; i++)
            {
                int min = i;
                for (int j = i + 1; j < mas.Length; j++)
                {
                    if (mas[j] < mas[min])
                    {
                        min = j;
                    }
                }
                int temp = mas[min];
                mas[min] = mas[i];
                mas[i] = temp;
            }
            return mas;
        }

        // Сортировка простым обменом
        static int[] BubbleSort(int[] masCopy)
        {
            int temp;
            for (int i = 0; i < masCopy.Length; i++)
            {
                for (int j = i + 1; j < masCopy.Length; j++)
                {
                    if (masCopy[i] > masCopy[j])
                    {
                        temp = masCopy[i];
                        masCopy[i] = masCopy[j];
                        masCopy[j] = temp;
                    }
                }
            }
            return masCopy;
        }

        // Сортировка шейкер
        static int[] SortShaker(int[] masCopy2)
        {
            int left = 1, right = masCopy2.Length - 1, last = right;

            do
            {
                for (int j = right; j >= left; j--)
                    if (masCopy2[j - 1] > masCopy2[j])
                    {
                        int t = masCopy2[j - 1];
                        masCopy2[j - 1] = masCopy2[j];
                        masCopy2[j] = t;
                        last = j;
                    }
                left = last;
                for (int j = left; j <= right; j++)
                    if (masCopy2[j - 1] > masCopy2[j])
                    {
                        int t = masCopy2[j - 1];
                        masCopy2[j - 1] = masCopy2[j];
                        masCopy2[j] = t;
                        last = j;
                    }
                right = last - 1;
            }
            while (left < right);

            return masCopy2;
        }

        // Прямой поиск
        static int SimpleSearch(int[] masCopy3, int x)
        {
            int i = 0;

            while (i < masCopy3.Length && masCopy3[i] != x)
                i++;
            if (i < masCopy3.Length)
                return i;
            else
                return -1;
        }

        // Бинарный поиск
        static int SearchBinary(int[] mas, int x)
        {
            int middle, left = 0, right = mas.Length - 1;

            do
            {
                middle = (left + right) / 2;
                if (x > mas[middle])
                    left = middle + 1;
                else
                    right = middle - 1;
            }
            while ((mas[middle] != x) && (left <= right));

            if (mas[middle] == x)
                return middle;
            else
                return -1;
        }

        // Прямой поиск в хэш-таблице
        static int SimpleSearchHash(int[] masCopy3, int x)
        {
            int i = 0;

            while (i < masCopy3.Length && masCopy3[i] != x)
                i++;
            if (i < masCopy3.Length)
                return i;
            else
                return -1;
        }

        // Бинарный поиск в хэш-таблице
        static int SearchBinaryHash(int[] mas, int x)
        {
            int middle, left = 0, right = mas.Length - 1;

            do
            {
                middle = (left + right) / 2;
                if (x > mas[middle])
                    left = middle + 1;
                else
                    right = middle - 1;
            }
            while ((mas[middle] != x) && (left <= right));

            if (mas[middle] == x)
                return middle;
            else
                return -1;
        }

        static void Main(string[] args)
        {

            Console.WriteLine("Введите желаемый размер коллекции.");
            int N = Convert.ToInt32(Console.ReadLine());

            // Коллекцию значений создаем единожды, поэтому после первой сортировки,
            // массив принимает в себя уже отсортированные значения и дальнейшие сортировки
            // становятся бесполезными. Во избежании подобной проблемы были созданы копии коллекции
            // значений для всех трех вариантов сортировки.

            // Коллекции для сортировки
            int[] mas = new int[N];
            int[] masCopy = new int[N];
            int[] masCopy2 = new int[N];
            // Коллекция для поиска
            int[] masCopy3 = new int[N];

            Random r = new Random();

            for (int i = 0; i < mas.Length; i++)
            {
                mas[i] = r.Next() % 1000;
            }

            // Копируем значения первой коллекции в остальные
            mas.CopyTo(masCopy, 0);
            mas.CopyTo(masCopy2, 0);
            mas.CopyTo(masCopy3, 0);

            // Создаем счетчики измерения времени алгоритмов
            Stopwatch swSort = new Stopwatch();
            Timing objT = new Timing();

            // Запускаем счетчики для сортировки простым выбором
            objT.StartTime();
            swSort.Start();
                SortSelection(mas);
            swSort.Stop();
            objT.StopTime();
            Console.WriteLine($"Сортировка выбором StopWatch (мс):{swSort.ElapsedMilliseconds.ToString()}");
            Console.WriteLine("Сортировка выбором Timing (мс):" + objT.Result().ToString());
            Console.WriteLine("---------------------------------------");

            // Чистим счетчик
            swSort.Reset();

            // Запускаем счетчики для сортировки простым обменом
            objT.StartTime();
            swSort.Start();
                BubbleSort(masCopy);
            swSort.Stop();
            objT.StopTime();
            Console.WriteLine($"Сортировка включениями StopWatch (мс):{swSort.ElapsedMilliseconds.ToString()}");
            Console.WriteLine("Сортировка включениями Timing (мс):" + objT.Result().ToString());
            Console.WriteLine("---------------------------------------");

            // Чистим счетчик
            swSort.Reset();

            // Запускаем счетчики для шейкер-сортировки 
            objT.StartTime();
            swSort.Start();
                SortShaker(masCopy2);
            swSort.Stop();
            objT.StopTime();
            Console.WriteLine($"Сортировка шейкер StopWatch (мс):{swSort.ElapsedMilliseconds.ToString()}");
            Console.WriteLine("Сортировка шейкер Timing (мс):" + objT.Result().ToString());
            Console.WriteLine("---------------------------------------");

            // Чистим счетчик
            swSort.Reset();

            // ----------------------------------------------------------------------------
            // В результате выполнения трех алгоритмов три раза подряд при помощи StopWatch
            // я получил следующие результаты работы алгоритмов:
            // 
            // Сортировка выбором:124, 117, 115
            // Сортировка включениями:177, 171, 179
            // Сортировка шейкер:231, 235, 232
            // ----------------------------------------------------------------------------
            // В результате выполнения трех алгоритмов три раза подряд при помощи Timing
            // я получил следующие результаты работы алгоритмов:
            // 
            // Сортировка выбором:109, 125, 93
            // Сортировка включениями:171, 171, 156
            // Сортировка шейкер:234, 234, 234
            // ----------------------------------------------------------------------------
            // Вывод первый: сортировка простым выбором выполняется
            // быстрее всех, а шейкер сортировка медленнее всех.
            // ----------------------------------------------------------------------------


            // Объявляем в переменную элемент, который будем искать
            Console.WriteLine("Ведите число, которое нужно найти:");
            int x = Convert.ToInt32(Console.ReadLine());

            // Проверка правильности работы прямого и бинарного поиска
            // Значение "-1" свидетельствует об отсутствии элемента или об ошибке
            Console.WriteLine("Индекс искомого числа: " + SimpleSearch(masCopy3, x) + ", " + SearchBinary(mas, x));

            // Измеряем скорость работы поисков при помощи ранее созданных таймеров
            // Запуск счетчиков для прямого поиска
            objT.StartTime();
            swSort.Start();
                SimpleSearch(masCopy3, x);
            swSort.Stop();
            objT.StopTime();
            Console.WriteLine($"Прямой поиск StopWatch (мс):{swSort.Elapsed.ToString()}");
            Console.WriteLine("Прямой поиск Timing (мс):" + objT.Result().ToString());
            Console.WriteLine("---------------------------------------");

            // Чистим счетчик
            swSort.Reset();

            // Запуск счетчиков для бинарного поиска
            objT.StartTime();
            swSort.Start();
                SearchBinary(mas, x);
            swSort.Stop();
            objT.StopTime();
            Console.WriteLine($"Бинарный поиск StopWatch (мс):{swSort.Elapsed.ToString()}");
            Console.WriteLine("Бинарный поиск Timing (мс):" + objT.Result().ToString());
            Console.WriteLine("---------------------------------------");

            // Чистим счетчик
            swSort.Reset();

            // ----------------------------------------------------------------------------
            // В результате выполнения двух алгоритмов при помощи StopWatch
            // я получил следующие результаты:
            //
            // Прямой поиск: 0000014
            // Бинарный поиск: 2187500
            // ----------------------------------------------------------------------------
            // В результате выполнения двух алгоритмов при помощи Timing
            // я получил следующие результаты:
            //
            // Прямой поиск: 0000010
            // Бинарный поиск: 2187500
            // ----------------------------------------------------------------------------
            // Вывод первый: бинарный поиск занимает больше времени, даже учитывая то, что
            // поиск проводиться в заранее отсортированном массиве.
            // ----------------------------------------------------------------------------

            // Создаем хеш-таблицу
            Hashtable userInfoHash = new Hashtable();

            // Добавим несколько записей
            for (int i = 0; i < 10000; i++)
            {
                userInfoHash.Add("id" + i, "user" + i);
            }

            // Запрос на ввод ключа элемента хэш-таблицы
            Console.WriteLine("Введите номер ключа элемента для поиска по хэш-таблице.");
            string hv = Console.ReadLine();


            // Запуск счетчиков для поиска по ключу в хэш-таблице
            objT.StartTime();
            swSort.Start();

                // Ищем и выводим элемент по ключу
                string searchKey = userInfoHash[hv].ToString();
                Console.WriteLine(searchKey);

            swSort.Stop();
            objT.StopTime();
            Console.WriteLine($"Хэш поиск по ключу StopWatch (мс):{swSort.Elapsed.ToString()}");
            Console.WriteLine("Хэш поиска по ключу Timing (мс):" + objT.Result().ToString());
            Console.WriteLine("---------------------------------------");

            // Стопим консоль
            Console.ReadLine();
        }
    }
}
