using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Reflection;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_6
{
    class Address
    {
        public string country;
        public string city;
        public string street;
        public int house;
        public int flat;

        public Address()
        {

        }

        public Address(string country, string city, string street, int house, int flat)
        {
            this.country = country;
            this.city = city;
            this.street = street;
            this.house = house;
            this.flat = flat;
        }

        public void Updade()
        {
            Console.WriteLine("Введите свою страну");
            country = Console.ReadLine();
            Console.WriteLine("Введите свой город");
            city = Console.ReadLine();
            Console.WriteLine("Введите свою улицу");
            street = Console.ReadLine();
            Console.WriteLine("Введите номер своего дома");
            house = Convert.ToInt32(Console.ReadLine());
            Console.WriteLine("Номер квартиры");
            flat = Convert.ToInt32(Console.ReadLine());
        }
        public void GetAddress()
        {
            Console.WriteLine("Адрес: " + country + ", " + city + ", " + street + ", " + house + ", " + flat);
        }
    }

    internal class Program
    {
        static void Main(string[] args)
        {
            string country;
            string city;
            string street;
            int house;
            int flat;
            int count = 2;
            Address[] adres = new Address[count];
            Address adr;


            for (int i = 0; i < count / 2; i++)
            {
                adr = new Address();
                adr.Updade();
                adres[i] = adr;
                adr.GetAddress();
            }

            Console.ReadLine();
        }

    }
}
