namespace Portal.Model
{
    public class ProductItem
    {
        public string ProductId { get; set; } = Guid.NewGuid().ToString();
        public string? ProductType { get; set; }      // e.g., Charger, Cable
        public string? ProductMerk { get; set; }      // e.g., ABB, Schneider
        public string? ProductModel { get; set; }     // e.g., Terra AC, EVLink
        public string? ProductDescription { get; set; }
        public int Quantity { get; set; }
        public string? Unit { get; set; }             // e.g., pcs, set, unit
    }

}
