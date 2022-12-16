using System;
using static System.Console;

namespace PracticWork10
{
    class Original
    {
        public void OriginalDouble(double value)
        {
            WriteLine("Method Original.OriginalDouble(), value = {0}", value);
        }

        public void OriginalInt(int value)
        {
            WriteLine("Method Original.OriginalInt(), value = {0}", value);
        }

        public void OriginalChar(char value)
        {
            WriteLine("Method Original.OriginalChar, value = {0}", value);
        }
    }
    interface ITarget
    {
        void ClientDouble(double value);
        void ClientInt(int value);
        void ClientChar(char value);
    }
    class Adapter : Original, ITarget
    {
        public void ClientDouble(double value)
        {
            OriginalDouble(value);
        }

        public void ClientInt(int value)
        {
            OriginalInt(value * 2);
        }

        public void ClientChar(char value)
        {
            for (int i = 0; i < 5; i++)
                OriginalChar(value);
        }
    }
    class Client
    {
        private ITarget client;
        public Client(ITarget _client)
        {
            client = _client;
        }
        public void Show()
        {
            client.ClientDouble(1.5);
            client.ClientInt(15);
            client.ClientChar('I');
        }
    }
    class Program
    {
        static void Main(string[] args)
        {
            Adapter adapter = new Adapter();

            Client client = new Client(adapter);

            client.Show();
        }
    }
}