/**
 * The ObjectPool interface defines a set of methods for managing a pool of reusable objects.
 * This interface can be implemented to create object pools for any type of object.
 *
 * @author gert
 */
public interface ObjectPool<T> {

    /**
     * Creates a new object and adds it to the pool.
     * This method is typically called when the pool is initialized or when an object is needed but none are available.
     */
    public void createObject();

    /**
     * Destroys an object and removes it from the pool.
     * This method is typically called when an object is no longer needed or when the pool is being shut down.
     *
     * @param object The object to destroy.
     */
    public void destroyObject(T object);

    /**
     * Borrows an object from the pool for use.
     * If no objects are currently available, this method will wait until one becomes available.
     * If the pool has been shut down, this method will throw a PoolException.
     *
     * @return The borrowed object.
     * @throws InterruptedException If the thread is interrupted while waiting for an object to become available.
     * @throws PoolException If the pool has been shut down.
     */
    public T borrowObject() throws InterruptedException, PoolException;

    /**
     * Returns an object to the pool.
     * If the validate parameter is true, the object will be validated before it is returned to the pool.
     * If the object is invalid, a PoolException will be thrown.
     *
     * @param object The object to return to the pool.
     * @param validate Whether or not to validate the object before returning it to the pool.
     * @throws InterruptedException If the thread is interrupted while returning the object to the pool.
     * @throws PoolException If the object is invalid and the validate parameter is true.
     */
    public void returnObject(T object, boolean validate) throws InterruptedException;

    /**
     * Cleans up the pool by destroying and recreating
