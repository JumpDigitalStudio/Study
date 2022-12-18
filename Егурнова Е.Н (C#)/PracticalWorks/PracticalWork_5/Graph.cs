using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_5
{
    internal class Graph
    {
        int[,] Adj;
        int[,] Path;
        int Size;
        int b = 1;

        public Graph(int size)
        {
            this.Size = size;
            Adj = new int[size, size];
            Path = new int[size, size];

            Fill();
        }

        public void Fill()
        { 
            // Алгоритм заполнения матрицы
            for (int i = 0; i < Size; i++)
            {
                for (int j = 0; j < Size; j++)
                {
                    Console.Write($"Введите значение элемента ({i + 1})({j + 1}): ");
                    Adj[i, j] = int.Parse(Console.ReadLine());
                }
            }
        }

        public void Show()
        { 
            // Алгоритм отображения матрицы

            Console.WriteLine("\n");

            for (int i = 0; i < Size; i++)
            {
                for (int j = 0; j < Size; j++)
                {
                    Console.Write($"{Adj[i, j]} ");
                }
                Console.WriteLine();
            }
        }

        public void Reachability()
        { 
            // Алгоритм формирования матрицы достижимости

            for (int i = 0; i < Size; i++)
                for (int j = 0; j < Size; j++)
                    Path[i, j] = Adj[i, j];
            for (int i = 1; i < Size; i++)
                for (int j = 0; j < i; j++)
                    if (Path[i, j] == 1)
                        for (int k = 0; k < Size; k++)
                            Path[i, k] = (Path[i, k] | Path[j, k]);
            for (int i = 0; i < Size - 1; i++)
                for (int j = i + 1; j < Size; j++)
                    if (Path[i, j] == 1)
                        for (int k = 0; k < Size; k++)
                            Path[i, k] = (Path[i, k] | Path[j, k]);
        }

        public void ReachabilityShow()
        { 
            // Алгоритм отображения матрицы достижимости

            Reachability();

            Console.WriteLine("\n");

            for (int i = 0; i < Size; i++)
            {
                for (int j = 0; j < Size; j++)
                {
                    Console.Write($"{Path[i, j]} ");
                }
                Console.WriteLine();
            }
        }
    }
}
